<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

function bundledSkillsPath(): string
{
    return dirname(__DIR__, 2).'/resources/boost/skills';
}

function packageRootPath(): string
{
    return dirname(__DIR__, 2);
}

/**
 * @return list<string>
 */
function expectedGitHubSkills(): array
{
    return [
        'github-workflow',
        'github-capture-idea',
        'github-create-issue',
        'github-plan-roadmap',
        'github-next-issue',
        'github-investigate-issue',
        'github-implement-issue',
        'github-create-pull-request',
        'github-release-review',
    ];
}

it('bundles every GitHub workflow skill with consistent skill metadata', function () {
    foreach (expectedGitHubSkills() as $name) {
        $skill = file_get_contents(bundledSkillsPath().'/'.$name.'/SKILL.md');

        expect($skill)
            ->not->toBeFalse()
            ->and($skill)->toMatch('/^name:\s*'.preg_quote($name, '/').'\s*$/m')
            ->and($skill)->toMatch('/^license:\s*MIT\s*$/m')
            ->and($skill)->toMatch('/^\s*author:\s*hamforge\s*$/m');
    }
});

it('bundles valid and consistent OpenAI metadata for every skill', function () {
    foreach (expectedGitHubSkills() as $name) {
        $metadataPath = bundledSkillsPath().'/'.$name.'/agents/openai.yaml';

        expect($metadataPath)->toBeFile();

        $metadata = Yaml::parseFile($metadataPath);

        if (! is_array($metadata) || ! isset($metadata['interface']) || ! is_array($metadata['interface'])) {
            throw new RuntimeException('OpenAI skill metadata must contain an interface mapping.');
        }

        $interface = $metadata['interface'];

        expect($metadata)->toHaveKeys(['interface'])
            ->and(array_keys($metadata))->toBe(['interface'])
            ->and($interface)
            ->toHaveKeys(['display_name', 'short_description', 'default_prompt'])
            ->and(array_keys($interface))->toBe([
                'display_name',
                'short_description',
                'default_prompt',
            ])
            ->and(is_string($interface['display_name']) && $interface['display_name'] !== '')->toBeTrue()
            ->and(is_string($interface['short_description']) && $interface['short_description'] !== '')->toBeTrue()
            ->and($interface['default_prompt'])->toBeString()
            ->toContain('$'.$name);
    }
});

it('bundles the doctrine references used by the workflow router', function () {
    $referencesPath = bundledSkillsPath().'/github-workflow/references';

    expect($referencesPath.'/contributions.md')->toBeFile()
        ->and($referencesPath.'/issues-and-labels.md')->toBeFile()
        ->and($referencesPath.'/maintenance-and-releases.md')->toBeFile();
});

it('is distributed as a guidance-only package without runtime wiring', function () {
    $composer = json_decode(
        (string) file_get_contents(packageRootPath().'/composer.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    if (! is_array($composer)) {
        throw new RuntimeException('Composer metadata must decode to an array.');
    }

    expect(array_intersect(['autoload', 'extra', 'require'], array_keys($composer)))->toBe([])
        ->and(glob(packageRootPath().'/src/*.php'))->toBe([])
        ->and(is_file(packageRootPath().'/testbench.yaml'))->toBeFalse()
        ->and(bundledSkillsPath())->toBeDirectory();
});
