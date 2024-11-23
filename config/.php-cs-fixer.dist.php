<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

$finder = PhpCsFixer\Finder::create()
	->in(__DIR__)
	->exclude('vendor')
	->exclude('storage')
	->exclude('bootstrap/cache');

// Direct call: php vendor/bin/php-cs-fixer fix app/ --config=config\.php-cs-fixer.dist.php
// Pour fix tout le projet:
// php vendor/bin/php-cs-fixer fix ./ --config=config\.php-cs-fixer.dist.php --cache-file=none

return (new PhpCsFixer\Config())
	->setRiskyAllowed(false)
	->setRules([
		'header_comment' => [
			'header'       => ' (ɔ) LARAVEL.Sillo.org - 2012-' . date('Y'),
			'comment_type' => 'PHPDoc',
			'location'     => 'after_declare_strict',
		],
		'@PHP81Migration'                        => true,
		'align_multiline_comment'                => ['comment_type' => 'all_multiline'],
		'array_syntax'                           => ['syntax' => 'short'],
		'explicit_string_variable'               => true,
		'array_indentation'                      => true,
		'indentation_type'                       => true,
		'no_blank_lines_after_class_opening'     => true,
		'no_blank_lines_after_phpdoc'            => true,
		'blank_line_after_opening_tag'           => true,
		'blank_line_before_statement'            => true,
		'single_blank_line_before_namespace'     => true,
		'blank_line_after_namespace'             => true,
		'new_with_braces'                        => true,
		'ordered_class_elements'                 => true,
		'ordered_imports'                        => true,
		'single_import_per_statement'            => false,
		'group_import'                           => true,
		'combine_consecutive_issets'             => true,
		'combine_consecutive_unsets'             => true,
		'multiline_whitespace_before_semicolons' => true,
		'single_quote'                           => true,
		'cast_spaces'                            => true,
		'concat_space'                           => ['spacing' => 'one'],
		'declare_equal_normalize'                => true,
		'function_typehint_space'                => true,
		'compact_nullable_typehint'              => true,
		'single_line_comment_style'              => true,
		'include'                                => true,
		'lowercase_cast'                         => true,
		'native_function_casing'                 => true,
		'object_operator_without_whitespace'     => true,
		'braces'                                 => [
			'allow_single_line_anonymous_class_with_empty_body' => true,
			'allow_single_line_closure'                         => true,
			'position_after_functions_and_oop_constructs'       => 'next',
			'position_after_control_structures'                 => 'next',
			'position_after_anonymous_constructs'               => 'next',
		],
		'no_extra_blank_lines' => [
			'tokens' => [
				'use',
				'extra',
				'break',
				'throw',
				'return',
				'continue',
				'curly_brace_block',
				'square_brace_block',
				'parenthesis_brace_block',
			],
		],
		'binary_operator_spaces' => [
			'default'   => 'single_space',
			'operators' => [
				'='  => 'align_single_space_minimal',
				'=>' => 'align_single_space_minimal',
			],
		],
		'class_attributes_separation' => [
			'elements' => [
				'method'   => 'one',
				'property' => 'none',
			],
		],
		'assign_null_coalescing_to_coalesce_equal'      => true,
		'escape_implicit_backslashes'                   => true,
		'explicit_indirect_variable'                    => true,
		'fully_qualified_strict_types'                  => true,
		'heredoc_to_nowdoc'                             => true,
		'list_syntax'                                   => ['syntax' => 'long'],
		'method_argument_space'                         => ['on_multiline' => 'ensure_fully_multiline'],
		'method_chaining_indentation'                   => true,
		'multiline_comment_opening_closing'             => true,
		'no_alternative_syntax'                         => true,
		'no_binary_string'                              => true,
		'no_leading_import_slash'                       => true,
		'no_leading_namespace_whitespace'               => true,
		'no_multiline_whitespace_around_double_arrow'   => true,
		'no_short_bool_cast'                            => true,
		'no_singleline_whitespace_before_semicolons'    => true,
		'no_trailing_comma_in_singleline_array'         => true,
		'no_spaces_around_offset'                       => true,
		'no_trailing_comma_in_list_call'                => true,
		'no_whitespace_before_comma_in_array'           => true,
		'no_whitespace_in_blank_line'                   => true,
		'normalize_index_brace'                         => true,
		'no_null_property_initialization'               => true,
		'no_superfluous_elseif'                         => true,
		'no_unneeded_control_parentheses'               => true,
		'no_unneeded_curly_braces'                      => true,
		'no_useless_else'                               => true,
		'no_useless_return'                             => true,
		'no_unused_imports'                             => true,
		'php_unit_internal_class'                       => true,
		'php_unit_method_casing'                        => true,
		'phpdoc_order_by_value'                         => ['annotations' => ['covers']],
		'php_unit_test_class_requires_covers'           => true,
		'phpdoc_add_missing_param_annotation'           => true,
		'phpdoc_order'                                  => true,
		'phpdoc_trim_consecutive_blank_line_separation' => true,
		'phpdoc_types_order'                            => true,
		'return_assignment'                             => true,
		'short_scalar_cast'                             => true,
		'standardize_not_equals'                        => true,
		'unary_operator_spaces'                         => true,
		'whitespace_after_comma_in_array'               => true,
		'semicolon_after_instruction'                   => true,
		'ternary_operator_spaces'                       => true,
		'trim_array_spaces'                             => true,
		'yoda_style'                                    => true,
		'trailing_comma_in_multiline'                   => ['elements' => ['arrays']],
	])
	->setIndent("\t")
	->setLineEnding("\n")
	->setFinder($finder);
