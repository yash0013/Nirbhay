<?php
// Load the chatbot dataset from CSV
$csvFile = 'ds/chatbot.csv';
$chatbotData = [];

// Read CSV data into a structured array
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Assuming the dataset has 3 columns: question, answer, category
        $chatbotData[] = [
            'question' => $data[0],
            'answer' => $data[1],
            'category' => $data[2]
        ];
    }
    fclose($handle);
}

// Debug: Check the loaded chatbot data
// var_dump($chatbotData); // Uncomment for debugging

// Handle chatbot interactions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = isset($_POST['step']) ? $_POST['step'] : '';

    // Step 1: Display help categories
    if ($step === 'categories') {
        // Extract unique categories
        $categories = array_unique(array_column($chatbotData, 'category'));
        $options = [];
        
        foreach ($categories as $index => $category) {
            $options[] = ['id' => $index + 1, 'text' => $category];
        }

        echo json_encode([
            'question' => 'What do you need help with? Select a category:',
            'options' => $options
        ]);
    }
    // Step 2: Display questions based on category with pagination
    elseif ($step === 'questions') {
        $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : 0;
        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

        // Check if the category ID is valid
        $categories = array_unique(array_column($chatbotData, 'category'));
        if (isset($categories[$categoryId - 1])) {
            $selectedCategory = $categories[$categoryId - 1];

            $questions = [];
            foreach ($chatbotData as $index => $item) {
                if ($item['category'] === $selectedCategory) {
                    // Check if within offset and limit
                    if ($index >= $offset && $index < $offset + 5) {
                        $questions[] = ['id' => $index + 1, 'text' => $item['question']];
                    }
                }
            }

            // Check if there are more questions available
            $totalQuestions = count(array_filter($chatbotData, function($item) use ($selectedCategory) {
                return $item['category'] === $selectedCategory;
            }));

            $hasMore = $totalQuestions > ($offset + 5);

            // Debug: Check which questions are being returned
            // var_dump($questions); // Uncomment for debugging

            echo json_encode([
                'question' => 'Select a question:',
                'options' => $questions,
                'hasMore' => $hasMore
            ]);
        } else {
            echo json_encode(['error' => 'Invalid category ID.']);
        }
    }
    // Step 3: Fetch answer based on the selected question
    elseif ($step === 'answer') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if (isset($chatbotData[$id - 1])) {
            $answer = $chatbotData[$id - 1]['answer'];
            echo json_encode(['answer' => $answer]);
        } else {
            echo json_encode(['answer' => 'Sorry, I do not understand that question.']);
        }
    }
    // Step 4: Reset to home categories
    elseif ($step === 'home') {
        echo json_encode([
            'question' => 'What do you need help with? Select a category:',
            'options' => array_unique(array_column($chatbotData, 'category'))
        ]);
    }
}
?>
