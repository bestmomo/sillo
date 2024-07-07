<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

return (new PhpCsFixer\Config())
	// https:// github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/doc/list.rst
	->setRiskyAllowed(false)
	->setRules(
		[
			'header_comment' => [
				'header'       => '(ɔ) LARAVEL.Sillo.org - 2015-' . date('Y'), // . date('Y'),
				'comment_type' => 'PHPDoc',
				'location'     => 'after_declare_strict',
			],

			'@PHP81Migration' => true,
			'@PSR12'          => true,
			'@Symfony'        => true,

			'align_multiline_comment' => ['comment_type' => 'all_multiline'],

			'array_syntax'             => ['syntax' => 'short'],
			'explicit_string_variable' => true,
			'array_indentation'        => true,
						'braces'                                 => [
				'allow_single_line_closure'                   => true,
				'position_after_control_structures'           => 'same',
				'position_after_functions_and_oop_constructs' => 'same',
			],
			'indentation_type'         => true,

			// 'no_blank_lines_before_namespace'    => true,
			'no_blank_lines_after_class_opening' => true,
			'no_blank_lines_after_phpdoc'        => true,
			'no_extra_blank_lines'               => [
				'tokens' => [
					'break',
					'continue',
					'return',
					'curly_brace_block',
					'curly_brace_block',
					'extra',
					'parenthesis_brace_block',
					'square_brace_block',
					'throw',
					'use',
				],
			],
			'blank_line_after_opening_tag'       => true,
			'blank_line_before_statement'        => true,
			'single_blank_line_before_namespace' => false,

			// 'no_empty_comment'   => true,
			// 'no_empty_phpdoc'    => true,
			// 'no_empty_statement' => true,

			'ordered_class_elements' => [
				'use_trait',
				'case',
				'constant_public',
				'constant_protected',
				'constant_private',
				'property_public',
				'property_protected',
				'property_private',
				'construct',
				'destruct',
				'magic',
				'phpunit',
				'method_public',
				'method_protected',
				'method_private',
			],

			'binary_operator_spaces' => [
				'default'   => 'single_space',
				'operators' => [
					'='  => 'align_single_space_minimal',
					'=>' => 'align_single_space_minimal',
				],
			],
			'combine_consecutive_issets' => true,
			'combine_consecutive_unsets' => true,

			'class_attributes_separation' => [
				'elements' => [
					'method'   => 'one',
					'property' => 'none',
				],
			],
			'multiline_whitespace_before_semicolons' => true,
			'single_quote'                           => true,
			'cast_spaces'               => true,
			'concat_space'              => ['spacing' => 'one'],
			'declare_equal_normalize'   => true,
			'function_typehint_space'   => true,
			'compact_nullable_typehint' => true,
			'single_line_comment_style'                     => true,
			'include'                   => true,
			'lowercase_cast'            => true,
			'native_function_casing'    => true,
			// 'new_with_braces' => true,

			'object_operator_without_whitespace' => true,

			// Début Config C57fr - Ex

			// Custom C57.fr 's rule
			'assign_null_coalescing_to_coalesce_equal' => true,
			// 'comment_to_phpdoc'                           => true,
			'escape_implicit_backslashes' => true,
			'explicit_indirect_variable'  => true,
			// 'final_internal_class'                        => true,
			'fully_qualified_strict_types' => true,
			// 'function_to_constant'                        => ['functions' => ['get_class',  'get_called_class', 'php_sapi_name', 'phpversion',   'pi']],
			'heredoc_to_nowdoc' => true,
			'list_syntax'       => ['syntax' => 'long'],
			// 'logical_operators'                           => true,
			'method_argument_space'             => ['on_multiline' => 'ensure_fully_multiline'],
			'method_chaining_indentation'       => true,
			'multiline_comment_opening_closing' => true,
			'no_alternative_syntax'             => true,
			'no_binary_string'                  => true,
			'no_leading_import_slash'                     => true,
			'no_leading_namespace_whitespace'             => true,
			'no_multiline_whitespace_around_double_arrow' => true,
			'no_short_bool_cast'                          => true,
			'no_singleline_whitespace_before_semicolons'  => true,
			'no_trailing_comma_in_singleline_array'       => true,
			'no_spaces_around_offset'                     => true,
			'no_trailing_comma_in_list_call'              => true,
			'no_whitespace_before_comma_in_array'         => true,
			'no_whitespace_in_blank_line'                 => true,
			// 'no_mixed_echo_print'                         => ['use' => 'echo'],

			'normalize_index_brace'           => true,
			'no_null_property_initialization' => true,
			'no_superfluous_elseif'           => true,
			'no_unneeded_control_parentheses' => true,
			'no_unneeded_curly_braces'        => true,
			// 'no_unneeded_final_method'                      => true,
			// 'no_unreachable_default_argument_value'         => true,
			// 'no_unset_on_property'                          => true,
			'no_useless_else'         => true,
			'no_useless_return'       => true,
			'no_unused_imports'       => true,
			'ordered_imports'         => true,
			'php_unit_internal_class' => true,
			'php_unit_method_casing'  => true,
			'phpdoc_order_by_value'   => ['annotations' => ['covers']],
			// 'php_unit_set_up_tear_down_visibility'          => true,
			// 'php_unit_strict'                               => true,
			// 'php_unit_test_annotation'                      => true,
			// 'php_unit_test_case_static_method_calls'        => ['call_type' => 'this'],
			'php_unit_test_class_requires_covers'           => true,
			'phpdoc_add_missing_param_annotation'           => true,
			'phpdoc_order'                                  => true,
			'phpdoc_trim_consecutive_blank_line_separation' => true,
			'phpdoc_types_order'                            => true,
			'return_assignment'                             => true,
			'single_class_element_per_statement'            => true,
			'short_scalar_cast'                             => true,
			'standardize_not_equals'                        => true,
			'unary_operator_spaces'                         => true,
			'whitespace_after_comma_in_array'               => true,
			'semicolon_after_instruction'                   => true,
			// 'strict_comparison'                             => true,
			// 'strict_param'                                  => true,
			// 'string_line_ending'                            => true,
			'ternary_operator_spaces'     => true,
			'trailing_comma_in_multiline' => true,
			'trim_array_spaces'           => true,
			'yoda_style'                  => true,
			'single_blank_line_at_eof'    => true,
			// 'space_after_semicolon'           => true,
		]
	)
	->setIndent("\t")
	->setLineEnding("\n");
