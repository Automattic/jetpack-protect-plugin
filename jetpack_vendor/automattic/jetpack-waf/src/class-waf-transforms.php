<?php
/**
 * Transforms for Jetpack Waf
 *
 * @package automattic/jetpack-waf
 */

namespace Automattic\Jetpack\Waf;

/**
 * Waf_Transforms class
 */
class Waf_Transforms {

	/**
	 * Decode a Base64-encoded string. This runs the decode without strict mode, to match Modsecurity's 'base64DecodeExt' transform function.
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function base64_decode_ext( $value ) {
		return base64_decode( $value );
	}

	/**
	 * Characters to match when trimming a string.
	 * Emulates `std::isspace` used by ModSecurity.
	 *
	 * @see https://en.cppreference.com/w/cpp/string/byte/isspace
	 */
	const TRIM_CHARS = " \n\r\t\v\f";

	/**
	 * Decode a Base64-encoded string. This runs the decode with strict mode, to match Modsecurity's 'base64Decode' transform function.
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function base64_decode( $value ) {
		return base64_decode( $value, true );
	}

	/**
	 * Remove all characters that might escape a command line command
	 *
	 * @see https://github.com/SpiderLabs/ModSecurity/wiki/Reference-Manual-%28v2.x%29#cmdLine
	 * @param string $value value to be escaped.
	 * @return string
	 */
	public function cmd_line( $value ) {
		return strtolower(
			preg_replace(
				'/\s+/',
				' ',
				str_replace(
					array( ',', ';' ),
					' ',
					preg_replace(
						'/\s+(?=[\/\(])/',
						'',
						str_replace(
							array( '^', "'", '"', '\\' ),
							'',
							$value
						)
					)
				)
			)
		);
	}

	/**
	 * Decode a SQL hex string.
	 *
	 * @example 414243 decodes to "ABC"
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function sql_hex_decode( $value ) {
		return preg_replace_callback(
			'/0x[a-f0-9]+/i',
			function ( $matches ) {
				$str = substr( $matches[0], 2 );
				if ( 0 !== strlen( $str ) % 2 ) {
					$str = '0' . $str;
				}
				return hex2bin( $str );
			},
			$value
		);
	}

	/**
	 * Encode a string using Base64 encoding.
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function base64_encode( $value ) {
		return base64_encode( $value );
	}

	/**
	 * Convert all whitespace characters to a space and remove any repeated spaces.
	 *
	 * @param string $value value to be converted.
	 * @return string
	 */
	public function compress_whitespace( $value ) {
		return preg_replace( '/\s+/', ' ', $value );
	}

	/**
	 * Encode string (possibly containing binary characters) by replacing each input byte with two hexadecimal characters.
	 *
	 * @param string $value value to be encoded.
	 * @return string
	 */
	public function hex_encode( $value ) {
		return bin2hex( $value );
	}

	/**
	 * Decode string that was previously encoded by hexEncode()
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function hex_decode( $value ) {
		return pack( 'H*', $value );
	}

	/**
	 * Decode the characters encoded as HTML entities.
	 *
	 * @param mixed $value value do be decoded.
	 * @return string
	 */
	public function html_entity_decode( $value ) {
		return html_entity_decode( $value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401 );
	}

	/**
	 * Return the length of the input string.
	 *
	 * @param string $value input string.
	 * @return int
	 */
	public function length( $value ) {
		return strlen( $value );
	}

	/**
	 * Convert all characters to lowercase.
	 *
	 * @param string $value string to be converted.
	 * @return string
	 */
	public function lowercase( $value ) {
		return strtolower( $value );
	}

	/**
	 * Calculate an md5 hash for the given data
	 *
	 * @param mixed $value value to be hashed.
	 * @return string
	 */
	public function md5( $value ) {
		return md5( $value, true );
	}

	/**
	 * Removes multiple slashes, directory self-references, and directory back-references (except when at the beginning of the input) from input string.
	 *
	 * @param string $value value to be normalized.
	 * @return string
	 */
	public function normalize_path( $value ) {
		$parts = explode(
			'/',
			// replace any duplicate slashes with a single one.
			preg_replace( '~/{2,}~', '/', $value )
		);

		$i = 0;
		while ( isset( $parts[ $i ] ) ) {
			switch ( $parts[ $i ] ) {
				// If this folder is a self-reference, remove it.
				case '..':
					// If this folder is a backreference, remove it unless we're already at the root.
					if ( isset( $parts[ $i - 1 ] ) && ! in_array( $parts[ $i - 1 ], array( '', '..' ), true ) ) {
						array_splice( $parts, $i - 1, 2 );
						--$i;
						continue 2;
					}
					break;
				case '.':
					array_splice( $parts, $i, 1 );
					continue 2;
			}
			++$i;
		}

		return implode( '/', $parts );
	}

	/**
	 * Convert backslash characters to forward slashes, and then normalize using `normalizePath`
	 *
	 * @param string $value to be normalized.
	 * @return string
	 */
	public function normalize_path_win( $value ) {
		return $this->normalize_path( str_replace( '\\', '/', $value ) );
	}

	/**
	 * Removes all NUL bytes from input.
	 *
	 * @param string $value value to be filtered.
	 * @return string
	 */
	public function remove_nulls( $value ) {
		return str_replace( "\x0", '', $value );
	}

	/**
	 * Remove all whitespace characters from input.
	 *
	 * @param string $value value to be filtered.
	 * @return string
	 */
	public function remove_whitespace( $value ) {
		return preg_replace( '/\s/', '', $value );
	}

	/**
	 * Replaces each occurrence of a C-style comment (/ * ... * /) with a single space.
	 * Unterminated comments will also be replaced with a space. However, a standalone termination of a comment (* /) will not be acted upon.
	 *
	 * @param string $value value to be filtered.
	 * @return string
	 */
	public function replace_comments( $value ) {
		$value = preg_replace( '~/\*.*?\*/|/\*.*?$~Ds', ' ', $value );
		return explode( '/*', $value, 2 )[0];
	}

	/**
	 * Removes common comments chars (/ *, * /, --, #).
	 *
	 * @param string $value value to be filtered.
	 * @return string
	 */
	public function remove_comments_char( $value ) {
		return preg_replace( '~/*|*/|--|#|//~', '', $value );
	}

	/**
	 * Replaces each NUL byte in input with a space.
	 *
	 * @param string $value value to be filtered.
	 * @return string
	 */
	public function replace_nulls( $value ) {
		return str_replace( "\x0", ' ', $value );
	}

	/**
	 * Decode a URL-encoded input string.
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function url_decode( $value ) {
		return urldecode( $value );
	}

	/**
	 * Decode a URL-encoded input string.
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function url_decode_uni( $value ) {
		error_log( 'JETPACKWAF TRANSFORM NOT IMPLEMENTED: urlDecodeUni' );
		return $value;
	}

	/**
	 * Decode a json encoded input string.
	 *
	 * @param string $value value to be decoded.
	 * @return string
	 */
	public function js_decode( $value ) {
		error_log( 'JETPACKWAF TRANSFORM NOT IMPLEMENTED: jsDecode' );
		return $value;
	}

	/**
	 * Convert all characters to uppercase.
	 *
	 * @param string $value value to be encoded.
	 * @return string
	 */
	public function uppercase( $value ) {
		return strtoupper( $value );
	}

	/**
	 * Calculate a SHA1 hash from the input string.
	 *
	 * @param mixed $value value to be hashed.
	 * @return string
	 */
	public function sha1( $value ) {
		return sha1( $value, true );
	}

	/**
	 * Remove whitespace from the left side of the input string.
	 *
	 * @param string $value value to be trimmed.
	 * @return string
	 */
	public function trim_left( $value ) {
		return ltrim( $value, self::TRIM_CHARS );
	}

	/**
	 * Remove whitespace from the right side of the input string.
	 *
	 * @param string $value value to be trimmed.
	 * @return string
	 */
	public function trim_right( $value ) {
		return rtrim( $value, self::TRIM_CHARS );
	}

	/**
	 * Remove whitespace from both sides of the input string.
	 *
	 * @param string $value value to be trimmed.
	 * @return string
	 */
	public function trim( $value ) {
		return trim( $value, self::TRIM_CHARS );
	}

	/**
	 * Convert UTF-8 characters to Unicode characters.
	 *
	 * This function iterates through each character of the input string, checks the ASCII value,
	 * and converts it to its corresponding Unicode representation. It handles characters that are
	 * represented with 1 to 4 bytes in UTF-8.
	 *
	 * @param string $str The string value to be encoded from UTF-8 to Unicode.
	 * @return string The converted string with Unicode representation.
	 */
	public function utf8_to_unicode( $str ) {
		$unicodeStr = '';
		$strLen     = strlen( $str );
		$i          = 0;

		// Iterate through each character of the input string.
		while ( $i < $strLen ) {
			// Get the ASCII value of the current character.
			$value = ord( $str[ $i ] );

			if ( $value < 128 ) {
				// If the character is in the ASCII range (0-127), directly add it to the Unicode string.
				$unicodeStr .= chr( $value );
				++$i;
			} else {
				// For characters outside the ASCII range, determine the number of bytes in the UTF-8 representation.
				$unicodeValue = '';
				if ( $value >= 192 && $value <= 223 ) {
					// For characters represented with 2 bytes in UTF-8.
					$unicodeValue = ( ord( $str[ $i ] ) & 0x1F ) << 6 | ( ord( $str[ $i + 1 ] ) & 0x3F );
					$i           += 2;
				} elseif ( $value >= 224 && $value <= 239 ) {
					// For characters represented with 3 bytes in UTF-8.
					$unicodeValue = ( ord( $str[ $i ] ) & 0x0F ) << 12 | ( ord( $str[ $i + 1 ] ) & 0x3F ) << 6 | ( ord( $str[ $i + 2 ] ) & 0x3F );
					$i           += 3;
				} elseif ( $value >= 240 && $value <= 247 ) {
					// For characters represented with 4 bytes in UTF-8.
					$unicodeValue = ( ord( $str[ $i ] ) & 0x07 ) << 18 | ( ord( $str[ $i + 1 ] ) & 0x3F ) << 12 | ( ord( $str[ $i + 2 ] ) & 0x3F ) << 6 | ( ord( $str[ $i + 3 ] ) & 0x3F );
					$i           += 4;
				} else {
					// If the sequence does not match any known UTF-8 pattern, skip to the next character.
					++$i;
					continue;
				}
				// Convert the Unicode value to a formatted string and append it to the Unicode string.
				$unicodeStr .= sprintf( '%%u%04X', $unicodeValue );
			}
		}

		return strtolower( $unicodeStr );
	}
}
