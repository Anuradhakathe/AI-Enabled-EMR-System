<?php
header("Content-Type: application/json");
include '../../assets/inc/config.php'; // adjust path as needed to connect to DB

// Basic responses
$responses = [
    'en' => [
        'greetings' => "👋 Hello! How can I assist you today?",
        'help' => "I can assist with login, registration, appointments, and checking medicine availability.",
        'login' => "🔐 Please visit the login page to access your dashboard.",
        'sign up' => "📝 Click on 'Register' to create a new account.",
        'forgot password' => "🔁 Use the 'Forgot Password' option to reset your credentials.",
        'book appointment' => "📅 Navigate to the appointments section to book your slot.",
        'default' => "🤖 I'm sorry, I didn't quite understand that. Could you rephrase?"
    ],
    'hi' => [
        'greetings' => "👋 नमस्ते! मैं आपकी कैसे सहायता कर सकता हूँ?",
        'help' => "मैं लॉगिन, रजिस्ट्रेशन, अपॉइंटमेंट और दवाइयों की जानकारी में सहायता कर सकता हूँ।",
        'login' => "🔐 कृपया लॉगिन पेज पर जाएं।",
        'sign up' => "📝 'रजिस्टर' पर क्लिक करें नया खाता बनाने के लिए।",
        'forgot password' => "🔁 पासवर्ड रीसेट करने के लिए 'पासवर्ड भूल गए' विकल्प चुनें।",
        'book appointment' => "📅 अपॉइंटमेंट बुक करने के लिए अपॉइंटमेंट सेक्शन में जाएं।",
        'default' => "😕 क्षमा करें, कृपया दोबारा पूछें।"
    ]
];

// Keywords mapping
$keywords = [
    'greetings' => ['hi', 'hello', 'hey', 'good morning', 'good evening', 'नमस्ते', 'हाय', 'हैलो'],
    'help' => ['help', 'assist', 'support', 'मदद', 'सहायता'],
    'login' => ['login', 'log in', 'लॉगिन', 'साइन इन'],
    'sign up' => ['register', 'sign up', 'खाता', 'साइन अप'],
    'forgot password' => ['forgot', 'reset password', 'पासवर्ड'],
    'book appointment' => ['appointment', 'doctor', 'अपॉइंटमेंट'],
    'medicine' => ['medicine', 'medicines', 'available', 'दवा', 'inventory', 'medicine list']
];

// Request input
$input = strtolower(trim($_GET['message'] ?? ''));
$lang = $_GET['lang'] ?? 'en';
$lang = in_array($lang, ['en', 'hi']) ? $lang : 'en';

$reply = $responses[$lang]['default'];

// Determine intent
$intent = null;
foreach ($keywords as $key => $phrases) {
    foreach ($phrases as $phrase) {
        if (strpos($input, $phrase) !== false) {
            $intent = $key;
            break 2;
        }
    }
}

// Respond based on intent
if ($intent === 'medicine') {
    $medQuery = $mysqli->query("SELECT med_name, med_quantity FROM his_med_inventory LIMIT 10");
    if ($medQuery && $medQuery->num_rows > 0) {
        $medicines = [];
        while ($row = $medQuery->fetch_assoc()) {
            $medicines[] = "💊 " . $row['med_name'] . " (Qty: " . $row['med_quantity'] . ")";
        }
        $reply = "📦 Available Medicines:\n" . implode("\n", $medicines);
    } else {
        $reply = "⚠️ No medicines currently available in inventory.";
    }
} elseif ($intent !== null) {
    $reply = $responses[$lang][$intent];
}

echo json_encode(['reply' => $reply]);
?>
