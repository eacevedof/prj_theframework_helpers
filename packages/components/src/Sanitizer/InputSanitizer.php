<?php

namespace EduardoAf\Components\Sanitizer;

use EduardoAf\Components\Traits\MailTrait;
use EduardoAf\Components\Traits\LogTrait;

final class InputSanitizer
{
    //@deuda un componente o trait no deberia usar otro trait o componente fuera del paquete donde se encuentra
    //los logs los gestiona el controller o el service
    //el limite por clase son 400 lineas. 20 lineas por metodo y maximo 20 metodos.
    // habria que partir esta clase en varias clases mas pequeñas
    use MailTrait, LogTrait;

    /**
     * Common XSS injection patterns to be detected and blocked
     */
    private const XSS_PATTERNS = [
        '/<script[^>]*>.*?<\/script>/is',
        '/<iframe[^>]*>.*?<\/iframe>/is',
        '/<object[^>]*>.*?<\/object>/is',
        '/<embed[^>]*>.*?<\/embed>/is',
        '/<applet[^>]*>.*?<\/applet>/is',
        '/<meta[^>]*>/is',
        '/<link[^>]*>/is',
        '/<style[^>]*>.*?<\/style>/is',
        '/<form[^>]*>.*?<\/form>/is',
        '/<input[^>]*>/is',
        '/<textarea[^>]*>.*?<\/textarea>/is',
        '/<select[^>]*>.*?<\/select>/is',
        // Dangerous URL schemes
        '/javascript:/i',
        '/vbscript:/i',
        '/livescript:/i',
        '/mocha:/i',
        '/jscript:/i',
        '/ecmascript:/i',
        // Data URIs that can be dangerous
        '/data:text\/html/i',
        '/data:application/i',
        '/data:text\/javascript/i',
        '/data:application\/javascript/i',
        '/data:text\/ecmascript/i',
        // Event handlers
        '/on\w+\s*=/i',
        // Dangerous CSS and JS functions
        '/expression\s*\(/i',
        '/url\s*\(/i',
        '/import\s*\(/i',
        '/eval\s*\(/i',
        '/setTimeout\s*\(/i',
        '/setInterval\s*\(/i',
        // DOM manipulation
        '/document\s*\./i',
        '/window\s*\./i',
        '/location\s*=/i',
        '/location\s*\./i',
        // Common JS functions used in XSS
        '/alert\s*\(/i',
        '/confirm\s*\(/i',
        '/prompt\s*\(/i',
        // SVG-based XSS
        '/<svg[^>]*>.*?<\/svg>/is',
        '/xmlns\s*=\s*["\']http:\/\/www\.w3\.org\/2000\/svg/i',
        // Base64 encoded attacks
        '/btoa\s*\(/i',
        '/atob\s*\(/i'
    ];

    /**
     * Common HTML/PHP/ASP injection patterns to be detected and blocked
     */
    private const HTML_INJECTION_PATTERNS = [
        '/<\?php/i',
        '/<\?=/i',
        '/<\s*\?/i',
        '/<%/i',
        '/%>/i',
        '/<asp:/i',
        '/<%@/i',
        '/<%=/i',
        '/<jsp:/i',
        '/<%--/i'
    ];

    /**
     * SQL Injection patterns to be detected and blocked
     */
    private const SQL_INJECTION_PATTERNS = [
        // SQL functions requiring parentheses — avoids false positives on words like "cast" in business names
        '/(\bcast\s*\()/i',
        '/(\bconvert\s*\()/i',
        // DDL keywords require a SQL-specific follow-up token
        '/(\bcreate\s+\b(table|procedure|function|database|view|index|trigger)\b)/i',
        '/(\balter\s+\b(table|procedure|function|database|view|column|index)\b)/i',
        // DML SELECT requires FROM clause (catches "SELECT ... FROM ..." constructs)
        '/(\bselect\b.+\bfrom\b)/i',
        // T-SQL variable declaration
        '/(\bdeclare\s+@)/i',
        // Common boolean-based injections
        '/(\bor\b\s+\b1\b\s*=\s*\b1\b)/i',
        '/(\band\b\s+\b1\b\s*=\s*\b1\b)/i',
        '/(\b1\b\s*=\s*\b1\b)/i',
        '/(\b1\b\s*=\s*\b0\b)/i',
        '/(\bor\b\s+\b1\b\s*=\s*\b0\b)/i',
        '/(\band\b\s+\b1\b\s*=\s*\b0\b)/i',
        // String-based injections
        '/(\'|\")(\s)*(or|and)(\s)*(\d)+(\s)*=(\s)*(\d)+/i',
        '/(\'|\")(\s)*(or|and)(\s)*(\'|\")\w+(\'|\")/i',
        // UNION-based injections
        '/(\bunion\b\s+\bselect\b)/i',
        '/(\bunion\b\s+\ball\b\s+\bselect\b)/i',
        // Dangerous SQL operations
        '/(\bdrop\b\s+\btable\b)/i',
        '/(\bdelete\b\s+\bfrom\b)/i',
        '/(\binsert\b\s+\binto\b)/i',
        '/(\bupdate\b\s+\bset\b)/i',
        // Stored procedures and functions
        '/(\bexec\b\s*\()/i',
        '/(\bexecute\b\s*\()/i',
        '/(\bsp_\w+)/i',
        '/(\bxp_\w+)/i',
        // SQL comments
        '/(--|\/\*|\*\/|#)/i',
        // SQL functions that can be dangerous
        '/(\bchar\b\s*\(\s*\d+\s*\))/i',
        '/(\bhex\b\s*\()/i',
        '/(\bunhex\b\s*\()/i',
        '/(\bascii\b\s*\()/i',
        '/(\bord\b\s*\()/i',
        '/(\bsubstring\b\s*\()/i',
        '/(\bconcat\b\s*\()/i',
        '/(\bload_file\b\s*\()/i',
        '/(\boutfile\b)/i',
        '/(\bdumpfile\b)/i',
        // Information schema and system tables
        '/(\binformation_schema\b)/i',
        '/(\bsys\.\w+)/i',
        '/(\bmaster\.\w+)/i',
        // Sleep and benchmark functions
        '/(\bsleep\b\s*\()/i',
        '/(\bbenchmark\b\s*\()/i',
        // Multiple statement separators
        '/;\s*(select|insert|update|delete|drop|create|alter)/i'
    ];

    public function __construct() {}

    public static function getInstance(): self
    {
        return new self();
    }

    /**
     * Main method - Sanitizes an array of primitives with comprehensive threat detection
     * Step 1: Detects all security threats and collects them for reporting
     * Step 2: Sanitizes all content and returns clean data
     * 
     * @param array $primitives Array of primitives to sanitize
     * @return array Sanitized array of primitives
     * @throws SecurityThreatDetectedException if security threats are detected (contains all threats found)
     */
    public function getSanitizedPrimitives(array $primitives): array
    {
        // Step 1: Detect all threats first
        $threatsFound = $this->detectAllThreats($primitives);

        if (count($threatsFound) > 0) {
            $this->logError("[SECURITY] Injection threats detected", __METHOD__);
            $attackInfo = $this->getAttackInformation($threatsFound, $primitives);
            $this->sendEmailOnSecurityThreat($attackInfo);
        }

        // Step 2: Sanitize and return clean data
        return $this->sanitizeArrayRecursively($primitives);
    }

    /**
     * Detects all security threats in an array recursively
     * Collects all threats found for comprehensive reporting
     * 
     * @param array $primitives Array to scan for threats
     * @param string $path Current path in the array (for detailed reporting)
     * @return array List of all threats found with their locations
     */
    private function detectAllThreats(array $primitives, string $path = ''): array
    {
        $threats = [];

        foreach ($primitives as $key => $value) {
            $currentPath = $path ? $path . '.' . $key : $key;

            // Check the key itself for threats
            if (is_string($key)) {
                $keyThreats = $this->detectThreatsInString($key, $currentPath . '[key]');
                $threats = array_merge($threats, $keyThreats);
            }

            if (is_array($value)) {
                // Recursively check nested arrays
                $nestedThreats = $this->detectAllThreats($value, $currentPath);
                $threats = array_merge($threats, $nestedThreats);
            } elseif (is_string($value)) {
                // Check string values for threats
                $valueThreats = $this->detectThreatsInString($value, $currentPath);
                $threats = array_merge($threats, $valueThreats);
            }
        }

        return $threats;
    }

    /**
     * Detects all security threats in a single string
     * 
     * @param string $value String to check
     * @param string $location Location identifier for reporting
     * @return array List of threats found in this string
     */
    private function detectThreatsInString(string $value, string $location): array
    {
        $threats = [];
        $lowerValue = strtolower($value);

        // Check for XSS patterns
        foreach (self::XSS_PATTERNS as $pattern) {
            if (preg_match($pattern, $lowerValue)) {
                $safeValue = $this->makeSafeForEmail($value);
                $threats[] = "XSS threat in [{$location}] (length: " . strlen($value) . "): " . $safeValue;
                break; // Only report first XSS match per field to avoid spam
            }
        }

        // Check for HTML injection patterns
        foreach (self::HTML_INJECTION_PATTERNS as $pattern) {
            if (preg_match($pattern, $lowerValue)) {
                $safeValue = $this->makeSafeForEmail($value);
                $threats[] = "HTML injection in [{$location}] (length: " . strlen($value) . "): " . $safeValue;
                break; // Only report first HTML injection match per field
            }
        }

        // Check for SQL injection patterns
        foreach (self::SQL_INJECTION_PATTERNS as $pattern) {
            if (preg_match($pattern, $lowerValue)) {
                $safeValue = $this->makeSafeForEmail($value);
                $threats[] = "SQL injection in [{$location}] (length: " . strlen($value) . "): " . $safeValue;
                break; // Only report first SQL injection match per field
            }
        }

        // Check for dangerous control characters
        if (preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', $value)) {
            $safeValue = $this->makeSafeForEmail($value);
            $threats[] = "Control characters in [{$location}] (length: " . strlen($value) . "): " . $safeValue;
        }

        // Check for URL encoded attacks
        if (preg_match('/(%[0-9a-f]{2}){3,}/i', $value)) {
            $decoded = urldecode($value);
            if ($decoded !== $value && strlen($decoded) < strlen($value)) {
                $decodedThreats = $this->detectThreatsInString($decoded, $location . '[decoded]');
                $threats = array_merge($threats, $decodedThreats);
            }
        }

        return $threats;
    }

    /**
     * Sanitizes an array recursively without throwing exceptions
     * 
     * @param array $primitives Array to sanitize
     * @return array Sanitized array
     */
    private function sanitizeArrayRecursively(array $primitives): array
    {
        $sanitized = [];

        foreach ($primitives as $key => $value) {
            $sanitizedKey = $this->sanitizeKey($key);

            if (is_array($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeArrayRecursively($value);
            } elseif (is_string($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeStringCompletely($value);
            } else {
                $sanitized[$sanitizedKey] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Completely sanitizes a string against all threats without throwing exceptions
     * Used in Step 2 after threat detection is complete
     * 
     * @param string $value String value to sanitize
     * @return string Completely sanitized string
     */
    private function sanitizeStringCompletely(string $value): string
    {
        if (empty(trim($value))) {
            return '';
        }

        $sanitized = trim($value);

        // Step 1: Remove all HTML tags and decode entities
        $sanitized = strip_tags($sanitized);
        $sanitized = html_entity_decode($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Step 2: Remove XSS patterns using our constants
        foreach (self::XSS_PATTERNS as $pattern) {
            $sanitized = preg_replace($pattern, '', $sanitized);
        }

        // Step 3: Remove HTML injection patterns using our constants
        foreach (self::HTML_INJECTION_PATTERNS as $pattern) {
            $sanitized = preg_replace($pattern, '', $sanitized);
        }

        // Step 4: Remove SQL injection patterns using our constants
        foreach (self::SQL_INJECTION_PATTERNS as $pattern) {
            $sanitized = preg_replace($pattern, '', $sanitized);
        }

        // Step 5: Remove control characters
        $sanitized = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $sanitized);

        // Step 6: Handle URL encoded attacks (decode and re-sanitize if needed)
        if (preg_match('/(%[0-9a-f]{2}){3,}/i', $sanitized)) {
            $decoded = urldecode($sanitized);
            if ($decoded !== $sanitized) {
                $sanitized = $this->sanitizeStringCompletely($decoded); // Recursive call
            }
        }

        // Step 7: Final HTML escape for output safety
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);

        return $sanitized;
    }

    /**
     * Sanitizes array keys to ensure they are safe
     * 
     * @param mixed $key Array key to sanitize
     * @return string Sanitized key
     */
    private function sanitizeKey($key): string
    {
        if (!is_string($key)) {
            $key = (string) $key;
        }

        // For keys, we only allow alphanumeric, underscore and dash
        $sanitized = preg_replace('/[^a-zA-Z0-9_\-]/', '', $key);

        if (empty($sanitized)) {
            $sanitized = 'sanitized_key_' . uniqid();
        }

        return $sanitized;
    }

    /**
     * Makes content safe for email reporting by escaping dangerous characters
     * and limiting length while preserving readability
     * 
     * @param string $value Potentially dangerous content
     * @return string Safe content for email
     */
    private function makeSafeForEmail(string $value): string
    {
        if (empty($value)) {
            return '[EMPTY_VALUE]';
        }

        // Limit length and add ellipsis if needed
        $maxLength = 200;
        $truncated = strlen($value) > $maxLength;
        $safeValue = substr($value, 0, $maxLength);

        // Escape HTML entities for safe email display
        $safeValue = htmlspecialchars($safeValue, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Replace control characters with readable representations
        $safeValue = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '[CTRL]', $safeValue);

        // Show if value was truncated
        if ($truncated) {
            $safeValue .= '... [TRUNCATED]';
        }

        return '"' . $safeValue . '"';
    }

    /**
     * Gathers comprehensive information about a security attack for forensic analysis
     * 
     * @param array $threatsFound List of threats detected
     * @param array $originalData Original data that contained threats
     * @return string Formatted attack information for email
     */
    private function getAttackInformation(array $threatsFound, array $originalData): string
    {
        $threatCount = count($threatsFound);
        $timestamp = date('Y-m-d H:i:s T');

        // Start building the comprehensive report
        $report = "🚨 SECURITY ATTACK DETECTED ({$threatCount} threat" . ($threatCount > 1 ? 's' : '') . ") 🚨\n\n";

        // === ATTACK SUMMARY ===
        $report .= "=== ATTACK SUMMARY ===\n";
        $report .= "Timestamp: {$timestamp}\n";
        $report .= "Attack Type: " . $this->determineAttackType($threatsFound) . "\n\n";

        // === NETWORK INFORMATION ===
        $report .= "=== NETWORK INFORMATION ===\n";
        $report .= "IP Address: " . $this->getClientIP() . "\n";
        $report .= "User Agent: " . $this->getUserAgent() . "\n";
        $report .= "Referer: " . $this->getReferer() . "\n";
        $report .= "Request Method: " . $this->getRequestMethod() . "\n";
        $report .= "Request URI: " . $this->getRequestURI() . "\n\n";

        // === USER INFORMATION ===
        $report .= "=== USER INFORMATION ===\n";
        $userInfo = $this->getUserInformation($originalData);
        $report .= $userInfo . "\n\n";

        // === SESSION INFORMATION ===
        $report .= "=== SESSION INFORMATION ===\n";
        $report .= "Session ID: " . $this->getSessionId() . "\n";
        $report .= "Session Data: " . $this->getSessionSummary() . "\n\n";

        // === THREAT DETAILS ===
        $report .= "=== THREAT DETAILS ===\n";
        foreach ($threatsFound as $index => $threat) {
            $report .= ($index + 1) . ". " . $threat . "\n";
        }
        $report .= "\n";

        // === RAW DATA SAMPLE ===
        $report .= "=== RAW DATA SAMPLE ===\n";
        $rawDataSample = $this->getSafeDataSample($originalData);
        $report .= $rawDataSample . "\n\n";

        return $report;
    }

    private function getClientIP(): string
    {
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                // Take first IP if multiple (comma-separated)
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                return $ip;
            }
        }
        return 'Unknown';
    }

    private function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }

    private function getReferer(): string
    {
        return $_SERVER['HTTP_REFERER'] ?? 'Direct Access';
    }

    private function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'Unknown';
    }

    private function getRequestURI(): string
    {
        return $_SERVER['REQUEST_URI'] ?? 'Unknown';
    }

    private function getSessionId(): string
    {
        return session_id() ?: 'No Session';
    }

    private function getSessionSummary(): string
    {
        if (empty($_SESSION)) {
            return 'No Session Data';
        }

        $sessionKeys = array_keys($_SESSION);
        return 'Keys: ' . implode(', ', array_slice($sessionKeys, 0, 10)) .
            (count($sessionKeys) > 10 ? ' ... (truncated)' : '');
    }

    private function getUserInformation(array $originalData): string
    {
        $userInfo = [];

        // Look for common user identifier fields
        $userFields = ['userId', 'user_id', 'authUserId', 'auth_user_id', 'email', 'username', 'login'];
        foreach ($userFields as $field) {
            if (isset($originalData[$field]) && !empty($originalData[$field])) {
                $userInfo[] = ucfirst($field) . ': ' . $originalData[$field];
            }
        }

        return empty($userInfo) ? 'No User Information Available' : implode(', ', $userInfo);
    }

    private function determineAttackType(array $threats): string
    {
        $types = [];
        foreach ($threats as $threat) {
            if (strpos($threat, 'XSS') !== false) $types['XSS'] = true;
            if (strpos($threat, 'SQL') !== false) $types['SQL Injection'] = true;
            if (strpos($threat, 'HTML') !== false) $types['HTML Injection'] = true;
        }
        return empty($types) ? 'Unknown' : implode(', ', array_keys($types));
    }

    private function getSafeDataSample(array $data): string
    {
        $sample = [];
        $count = 0;
        foreach ($data as $key => $value) {
            if ($count >= 5) break; // Limit sample size
            if (is_string($value)) {
                $safeValue = strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                $sample[] = $key . ': "' . htmlspecialchars($safeValue, ENT_QUOTES, 'UTF-8') . '"';
            } else {
                $sample[] = $key . ': [' . gettype($value) . ']';
            }
            $count++;
        }
        return implode("\n", $sample);
    }

    /**
     * Validates if a string contains only allowed characters:
     * - Letters (a-z, A-Z) with accents/tildes
     * - Numbers (0-9)
     * - Underscore (_)
     * - Hyphen/dash (-)
     * - Period (.)
     * - Comma (,)
     * - Space ( )
     * 
     * @param string $value String to validate
     * @return bool True if valid, false otherwise
     */
    public static function containsOnlyAllowedCharacters(string $value): bool
    {
        // Pattern allows: letters with diacritics, numbers, underscore, hyphen, period, comma, space, slash, backslash
        // \p{L} matches any letter in any language (including accented characters)
        // \p{N} matches any number in any language
        $pattern = '/^[\p{L}\p{N}\s_\-.,\/\\\\]+$/u';

        return preg_match($pattern, $value) === 1;
    }

    /**
     * Validates an array of primitives with allowed characters validation
     * Throws exception if invalid characters are found
     * 
     * @param array $primitives Array of primitives to validate
     * @param array $fieldsToValidate Specific fields to validate (empty means all string fields)
     * @return array The same array if valid
     * @throws \InvalidArgumentException if invalid characters are found
     */
    public function validateAllowedCharacters(array $primitives, array $fieldsToValidate = []): array
    {
        $invalidFields = [];

        foreach ($primitives as $key => $value) {
            // Skip if we have specific fields to validate and this isn't one of them
            if (!empty($fieldsToValidate) && !in_array($key, $fieldsToValidate)) {
                continue;
            }

            if (is_string($value) && !empty(trim($value))) {
                if (!self::containsOnlyAllowedCharacters($value)) {
                    $invalidFields[] = $key;
                }
            } elseif (is_array($value)) {
                // Recursively validate nested arrays
                try {
                    $this->validateAllowedCharacters($value, $fieldsToValidate);
                } catch (\InvalidArgumentException $e) {
                    $invalidFields[] = $key . '[nested]';
                }
            }
        }

        if (!empty($invalidFields)) {
            throw new \InvalidArgumentException(
                "Los siguientes campos contienen caracteres no permitidos: " . implode(', ', $invalidFields) .
                    ". Solo se permiten letras, números, espacios y los símbolos: _ - . , / \\"
            );
        }

        return $primitives;
    }
}
