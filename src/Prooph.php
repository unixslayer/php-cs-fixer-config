<?php

/**
 * This file is part of `prooph/php-cs-fixer-config`.
 * (c) 2016-2025 prooph software GmbH <contact@prooph.de>
 * (c) 2016-2025 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\CS\Config;

use PhpCsFixer\Config;

class Prooph extends Config
{
    public function __construct()
    {
        parent::__construct('prooph');

        $this->setRiskyAllowed(true);
    }

    public function getRules(): array
    {
        $rules = [
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'binary_operator_spaces' => [
                'operators' => [
                    '=>' => 'single_space',
                    '=' => 'single_space',
                ],
            ],
            'blank_line_after_opening_tag' => true,
            'blank_line_after_namespace' => true,
            'blank_line_before_statement' => true,
            'braces' => true,
            'cast_spaces' => true,
            'class_definition' => true,
            'combine_consecutive_unsets' => true,
            'concat_space' => false,
            'declare_strict_types' => true,
            'echo_tag_syntax' => [
                'format' => 'long',
            ],
            'elseif' => true,
            'encoding' => true,
            'full_opening_tag' => true,
            'function_declaration' => true,
            'function_typehint_space' => true,
            'single_line_comment_style' => true,
            'header_comment' => [
                'comment_type' => 'PHPDoc',
                'header' => 'Prooph was here at `%package%` in `%year%`! Please create a .docheader in the project root and run `composer cs-fix`',
                'location' => 'after_open',
                'separate' => 'both',
            ],
            'include' => true,
            'indentation_type' => true,
            'linebreak_after_opening_tag' => true,
            'line_ending' => true,
            'constant_case' => [
                'case' => 'lower',
            ],
            'lowercase_keywords' => true,
            'method_argument_space' => true,
            'class_attributes_separation' => true,
            'modernize_types_casting' => true,
            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'no_multi_line',
            ],
            'native_function_casing' => true,
            'native_function_invocation' => [
                'include' => ['@internal'],
                'scope' => 'all',
            ],
            'new_with_braces' => true,
            'no_alias_functions' => true,
            'no_blank_lines_after_class_opening' => true,
            'no_closing_tag' => true,
            'no_empty_statement' => true,
            'no_extra_blank_lines' => true,
            'no_leading_import_slash' => true,
            'no_leading_namespace_whitespace' => true,
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_short_bool_cast' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_around_offset' => true,
            'no_trailing_comma_in_list_call' => true,
            'no_trailing_comma_in_singleline_array' => true,
            'no_unneeded_control_parentheses' => true,
            'no_unreachable_default_argument_value' => true,
            'no_unused_imports' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'no_spaces_inside_parenthesis' => true,
            'no_trailing_whitespace_in_comment' => true,
            'no_whitespace_before_comma_in_array' => true,
            'no_whitespace_in_blank_line' => true,
            'normalize_index_brace' => true,
            'not_operator_with_successor_space' => true,
            'object_operator_without_whitespace' => true,
            'ordered_imports' => true,
            'phpdoc_indent' => true,
            'phpdoc_inline_tag_normalizer' => true,
            'phpdoc_tag_type' => true,
            'psr_autoloading' => true,
            'return_type_declaration' => true,
            'semicolon_after_instruction' => true,
            'short_scalar_cast' => true,
            'simplified_null_return' => false,
            'single_blank_line_at_eof' => true,
            'single_class_element_per_statement' => true,
            'single_import_per_statement' => true,
            'single_line_after_imports' => true,
            'single_quote' => true,
            'standardize_not_equals' => true,
            'strict_comparison' => true,
            'switch_case_semicolon_to_colon' => true,
            'switch_case_space' => true,
            'ternary_operator_spaces' => true,
            'trailing_comma_in_multiline' => [
                'elements' => [
                    'arrays',
                ],
            ],
            'trim_array_spaces' => true,
            'unary_operator_spaces' => true,
            'visibility_required' => true,
            'whitespace_after_comma_in_array' => true,
        ];

        $rules['header_comment'] = $this->headerComment($rules['header_comment']);

        return $rules;
    }

    private function headerComment(array $rules): array
    {
        if (\file_exists('.docheader')) {
            $header = \file_get_contents('.docheader');
        } else {
            $header = $rules['header'];
        }

        // remove comments from existing .docheader or crash
        $header = \str_replace(['/**', ' */', ' * ', ' *'], '', $header);
        $package = 'unknown';

        if (\file_exists('composer.json')) {
            $package = \json_decode(\file_get_contents('composer.json'))->name;
        }

        $header = \str_replace(['%package%', '%year%'], [$package, (new \DateTime('now'))->format('Y')], $header);

        $rules['header'] = \trim($header);

        return $rules;
    }
}
