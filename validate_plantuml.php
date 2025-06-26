<?php
/**
 * PlantUML Syntax Validator
 * This script checks for common PlantUML syntax issues
 */

function validatePlantUML($filePath) {
    if (!file_exists($filePath)) {
        return ["Error: File not found: $filePath"];
    }
    
    $content = file_get_contents($filePath);
    $lines = explode("\n", $content);
    $errors = [];
    $warnings = [];
    
    // Check basic structure
    if (!preg_match('/^@startuml/', $content)) {
        $errors[] = "Missing @startuml at the beginning";
    }
    
    if (!preg_match('/@enduml$/', trim($content))) {
        $errors[] = "Missing @enduml at the end";
    }
    
    // Check for problematic characters
    foreach ($lines as $lineNum => $line) {
        $lineNumber = $lineNum + 1;
        
        // Check for emojis (should be removed)
        if (preg_match('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}]/u', $line)) {
            $warnings[] = "Line $lineNumber: Contains emoji characters that may cause rendering issues";
        }
        
        // Check for unmatched quotes
        $quotes = substr_count($line, '"');
        if ($quotes % 2 !== 0 && !empty(trim($line)) && !preg_match('/^\s*note/', $line)) {
            $warnings[] = "Line $lineNumber: Unmatched quotes detected";
        }
        
        // Check for invalid theme
        if (preg_match('/!theme\s+([^\s]+)/', $line, $matches)) {
            $theme = $matches[1];
            $validThemes = ['plain', 'aws-orange', 'bluegray', 'blueprint', 'cerulean', 'cerulean-outline', 'crt-amber', 'crt-green', 'cyborg', 'cyborg-outline', 'hacker', 'lightgray', 'mars', 'materia', 'materia-outline', 'metal', 'mimeograph', 'minty', 'plain', 'reddress-darkblue', 'reddress-darkgreen', 'reddress-darkorange', 'reddress-darkred', 'reddress-lightblue', 'reddress-lightgreen', 'reddress-lightorange', 'reddress-lightred', 'sandstone', 'silver', 'sketchy', 'sketchy-outline', 'spacelab', 'spacelab-white', 'superhero', 'superhero-outline', 'toy', 'united', 'vibrant'];
            
            if (!in_array($theme, $validThemes)) {
                $warnings[] = "Line $lineNumber: Theme '$theme' may not be valid. Consider using 'plain' for compatibility";
            }
        }
    }
    
    return [
        'errors' => $errors,
        'warnings' => $warnings,
        'line_count' => count($lines),
        'status' => empty($errors) ? 'Valid' : 'Invalid'
    ];
}

// Validate the PlantUML file
$filePath = __DIR__ . '/plantuml_authentication_sequences.puml';
$result = validatePlantUML($filePath);

echo "<h1>PlantUML Validation Results</h1>";
echo "<p><strong>File:</strong> " . basename($filePath) . "</p>";
echo "<p><strong>Status:</strong> <span style='color: " . ($result['status'] === 'Valid' ? 'green' : 'red') . "'>" . $result['status'] . "</span></p>";
echo "<p><strong>Total Lines:</strong> " . $result['line_count'] . "</p>";

if (!empty($result['errors'])) {
    echo "<h2 style='color: red;'>Errors:</h2>";
    echo "<ul>";
    foreach ($result['errors'] as $error) {
        echo "<li style='color: red;'>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
}

if (!empty($result['warnings'])) {
    echo "<h2 style='color: orange;'>Warnings:</h2>";
    echo "<ul>";
    foreach ($result['warnings'] as $warning) {
        echo "<li style='color: orange;'>" . htmlspecialchars($warning) . "</li>";
    }
    echo "</ul>";
}

if (empty($result['errors']) && empty($result['warnings'])) {
    echo "<p style='color: green; font-weight: bold;'>✅ No issues found! Your PlantUML file should render correctly.</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Copy the content of <code>plantuml_authentication_sequences.puml</code></li>";
echo "<li>Go to <a href='https://www.plantuml.com/plantuml/uml/' target='_blank'>PlantUML Online Editor</a></li>";
echo "<li>Paste the content and click 'Submit' to generate the diagram</li>";
echo "<li>If you have PlantUML installed locally, run: <code>java -jar plantuml.jar plantuml_authentication_sequences.puml</code></li>";
echo "</ol>";

echo "<h2>File Preview (First 20 lines):</h2>";
if (file_exists($filePath)) {
    $content = file_get_contents($filePath);
    $lines = explode("\n", $content);
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
    for ($i = 0; $i < min(20, count($lines)); $i++) {
        echo sprintf("%3d: %s\n", $i + 1, htmlspecialchars($lines[$i]));
    }
    if (count($lines) > 20) {
        echo "... (" . (count($lines) - 20) . " more lines)\n";
    }
    echo "</pre>";
}
?>