<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 project.
 *
 * (c) 2019-2021 Benni Mack
 *               Simon Gilli
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CodingStandards;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

class CsFixerConfig extends Config
{
    /**
     * @var string
     */
    private static $defaultHeader = <<<EOF
{header}

It is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License, either version 2
of the License, or any later version.

For the full copyright and license information, please read the
LICENSE.txt file that was distributed with this source code.

The TYPO3 project - inspiring people to share!
EOF;

    /**
     * @var array<string, mixed>
     */
    private static $typo3Rules = [
        '@DoctrineAnnotation' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => true,
        'braces' => ['allow_single_line_closure' => true],
        'cast_spaces' => ['space' => 'none'],
        'compact_nullable_typehint' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'none'],
        'dir_constant' => true,
        'function_typehint_space' => true,
        'lowercase_cast' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'modernize_types_casting' => true,
        'native_function_casing' => true,
        'new_with_braces' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_null_property_initialization' => true,
        'no_short_bool_cast' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_imports' => true,
        'php_unit_construct' => ['assertions' => ['assertEquals', 'assertSame', 'assertNotEquals', 'assertNotSame']],
        'php_unit_mock_short_will_return' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
        'phpdoc_no_access' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'return_type_declaration' => ['space_before' => 'none'],
        'single_quote' => true,
        'single_line_comment_style' => ['comment_types' => ['hash']],
        'single_trait_insert_per_statement' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'whitespace_after_comma_in_array' => true,
    ];

    public function __construct(string $name = 'TYPO3')
    {
        parent::__construct($name);
    }

    public static function create(): ConfigInterface
    {
        $config = (new self())
            ->setRiskyAllowed(true)
            ->setRules(self::$typo3Rules);

        /** @var Finder */
        $finder = $config->getFinder();
        $finder->exclude(['vendor', 'typo3temp', 'var', '.build']);

        return $config;
    }

    /**
     * @param array<string, mixed> $rules
     */
    public function addRules(array $rules): ConfigInterface
    {
        $rules = array_replace_recursive($this->getRules(), $rules);
        return $this->setRules($rules);
    }

    public function setHeader(
        string $header = 'This file is part of the TYPO3 CMS project.',
        bool $replaceAll = false
    ): ConfigInterface {
        if (!$replaceAll) {
            $header = str_replace('{header}', $header, self::$defaultHeader);
        }
        $rules = $this->getRules();
        $rules['header_comment'] = [
            'header' => $header,
            'comment_type' => 'comment',
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ];
        return $this->setRules($rules);
    }
}
