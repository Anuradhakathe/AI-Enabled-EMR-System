let lang = "en";

// Static response patterns
const responses = {
  en: {
    greetings: ["hi", "hello", "hey", "good morning", "good evening"],
    help: ["help", "assist", "support", "what can you do"],
    inventory: ["check medicine", "available medicines", "inventory", "stock"],
    default: "🤖 I'm sorry, I didn't quite understand that. Could you rephrase?"
  },
  hi: {
    greetings: ["नमस्ते", "हाय", "हैलो"],
    help: ["मदद", "सहायता", "क्या कर सकते हो"],
    inventory: ["दवा सूची", "दवा उपलब्ध", "इंवेंटरी", "स्टॉक"],
    default: "😕 माफ करें, मैं समझ नहीं पाया। कृपया फिर से पूछें।"
  }
};

// Map keywords to reply
const replyMap = {
  greetings: {
    en: "👋 Hello! I can assist with appointments, inventory, and more.",
    hi: "👋 नमस्ते! मैं आपकी सहायता अपॉइंटमेंट, दवाओं आदि में कर सकता हूँ।"
  },
  help: {
    en: "I can assist with booking, checking available medicines, and more.",
    hi: "मैं अपॉइंटमेंट, दवा की जानकारी आदि में आपकी मदद कर सकता हूँ।"
  }
};

function toggleChat() {
  const box = document.getElementById("chatbotBox");
  box.style.display = box.style.display === "flex" ? "none" : "flex";
  document.getElementById("chatBody").scrollTop = document.getElementById("chatBody").scrollHeight;
}

function handleKeyPress(event) {
  if (event.key === "Enter") sendMessage();
}

function sendMessage() {
  const input = document.getElementById("userInput");
  const text = input.value.trim();
  if (!text) return;

  addMessage(text, "user");

  setTimeout(() => {
    getBotResponse(text.toLowerCase());
  }, 500);

  input.value = "";
}

function addMessage(text, sender = "bot") {
  const div = document.createElement("div");
  div.className = `chat-message ${sender}`;
  div.innerText = text;
  document.getElementById("chatBody").appendChild(div);
  document.getElementById("chatBody").scrollTop = document.getElementById("chatBody").scrollHeight;
}

function changeLanguage() {
  lang = document.getElementById("language").value;
  const selected = document.getElementById("language").selectedOptions[0].text;
  addMessage(`🌐 Language changed to ${selected}`, "bot");
}

function getBotResponse(msg) {
  const wordSet = responses[lang];

  for (const key in wordSet) {
    if (Array.isArray(wordSet[key])) {
      for (const phrase of wordSet[key]) {
        if (msg.includes(phrase)) {
          if (key === "inventory") {
            fetchMedicines();
            return;
          }
          return addMessage(replyMap[key]?.[lang] || wordSet.default);
        }
      }
    }
  }

  return addMessage(wordSet.default);
}

// Call medicine API
function fetchMedicines() {
  addMessage("🔍 Checking available medicines, please wait...", "bot");

  fetch('/chatbot/api/get_medicines.php')
    .then(res => res.json())
    .then(data => {
      if (Array.isArray(data) && data.length > 0) {
        let medList = "💊 Available Medicines:\n";
        data.forEach((med, i) => {
          medList += `${i + 1}. ${med.name} (${med.quantity} units)\n`;
        });
        addMessage(medList, "bot");
      } else {
        addMessage("⚠️ No medicines found in inventory.", "bot");
      }
    })
    .catch(err => {
      addMessage("❌ Error fetching medicines. Try again later.", "bot");
      console.error(err);
    });
}
