<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$birthday = trim($data['birthday'] ?? '');

if (empty($name) || empty($birthday)) {
    http_response_code(400);
    echo json_encode(['error' => 'Name and birthday required']);
    exit;
}

// ========== 150+ UNIQUE BIRTHDAY MESSAGES ==========
$messages = [
    // Heartfelt & Warm (25 messages)
    "Happy Birthday, $name! 🎂 May your day be as bright and beautiful as your smile!",
    "Wishing you a birthday filled with love, laughter, and everything you deserve, $name! 💖",
    "$name, today the world celebrates YOU! May your heart be as full as your cake is sweet! 🎉",
    "Happy Birthday to someone who makes the world a better place just by being in it, $name! ✨",
    "$name, you're not just aging, you're upgrading! Have a spectacular birthday! 🚀",
    "May your birthday be as wonderful and unique as you are, $name! Sending you all the good vibes! 🌟",
    "Happy Birthday, $name! Your presence is a gift to everyone around you! 🎁",
    "$name, you make the world a more beautiful place. Happy Birthday! 🌹",
    "Happy Birthday, $name! Your energy is infectious and your spirit is unstoppable! 💥",
    "$name, you're proof that the best things in life come in amazing packages! 📦",
    "Happy Birthday to the most wonderful $name I know! You're a blessing! 🙌",
    "$name, you deserve all the happiness in the world today and always! 🌍",
    "Happy Birthday! $name, you're the sunshine on a cloudy day! ☀️",
    "$name, your presence is a gift to everyone around you. Happy Birthday! 🎁",
    "Happy Birthday, $name! You're the queen/king of your own fairytale! 👑",
    "$name, may your birthday be as magical as you are! ✨",
    "Happy Birthday! $name, you're a rare gem in this world! 💎",
    "$name, you make the world a more beautiful place. Happy Birthday! 🌹",
    "Happy Birthday, $name! Your laughter is the best medicine! 😂",
    "$name, you're the life of the party, every day! Happy Birthday! 🎈",
    "Happy Birthday, $name! You're the answer to someone's prayers! 🙏",
    "$name, your story is still being written, and it's a bestseller! 📚",
    "Happy Birthday, $name! You're a trendsetter, not a follower! 💫",
    "$name, you've got the magic touch! Happy Birthday! ✨",
    "Happy Birthday, $name! You're the reason people smile! 😊",

    // Playful & Fun (20 messages)
    "Happy Birthday, $name! 🥳 Remember, you're not old, you're just a classic!",
    "$name, another year older, but definitely not wiser! Enjoy your special day! 😉",
    "Warning: $name is now officially too cool for their age! Happy Birthday! 🔥",
    "Happy Birthday, $name! You're the sprinkles on my cupcake! 🧁",
    "$name, you're like fine wine - you get better with age! Cheers! 🍷",
    "It's your birthday, $name! Time to eat cake and pretend calories don't count! 🎂",
    "$name, you're not getting older, you're just becoming a classic! 🎸",
    "Happy Birthday, $name! You're older than you were yesterday! 🤷",
    "$name, I was going to get you a gift, but I spent it all on cake! 🎂",
    "Happy Birthday, $name! You're like a fine cheese - getting better with age! 🧀",
    "$name, congratulations on surviving another trip around the sun! 🌞",
    "Happy Birthday, $name! You're not getting old, you're leveling up! 🎮",
    "$name, you've reached the perfect age to stop counting! 🧮",
    "Happy Birthday, $name! Your birthday suit is the best suit you'll wear today! 😂",
    "$name, don't count the candles, count the blessings! 🕯️",
    "Happy Birthday! $name, you're so cool, you make ice jealous! ❄️",
    "$name, you're the GOAT of birthdays! 🐐",
    "Happy Birthday, $name! You've got the best energy in the room! ⚡",
    "$name, you're the MVP of my life! Happy Birthday! 🏀",
    "Happy Birthday! $name, you're totally the GOAT! 🐐",

    // Inspirational (20 messages)
    "$name, today is YOUR day! Chase your dreams, eat your cake, and shine bright! 💫",
    "Happy Birthday, $name! The world needs more people like you. Keep being amazing! 🌍",
    "May this year bring you everything you've been wishing for, $name! You deserve it all! 🌈",
    "$name, your future is as bright as the candles on your cake! Make a wish and go get it! 🕯️",
    "Happy Birthday! $name, you're proof that good things come to those who wait! 🎂",
    "$name, keep being the amazing person you are. Happy Birthday! 🌈",
    "Happy Birthday, $name! Your journey is just beginning. Enjoy the ride! 🚗",
    "$name, the best is yet to come. Happy Birthday and cheers to new beginnings! 🥂",
    "Happy Birthday, $name! You've got this! This year is YOUR year! 💪",
    "$name, never forget how incredible you are. Happy Birthday! 🌟",
    "$name, you're the main character of today's story! 🎬",
    "Happy Birthday, $name! You're a 10/10! Have a perfect birthday! ⭐",
    "$name, you've got the magic touch! Happy Birthday! ✨",
    "Happy Birthday, $name! You're the reason people smile! 😊",
    "$name, your heart is as big as your smile! Happy Birthday! ❤️",
    "Happy Birthday, $name! You're a trendsetter, not a follower! 💫",
    "$name, you're proof that dreams do come true! Happy Birthday! 🌟",
    "Happy Birthday, $name! Your light shines brighter than the stars! ⭐",
    "$name, you're destined for greatness! Happy Birthday! 🏆",
    "Happy Birthday, $name! You're the captain of your own ship! 🚢",

    // Short & Sweet (15 messages)
    "Happy Birthday, $name! 🎈 You're a star!",
    "$name, you're the best! Have an amazing birthday! 🎉",
    "Cheers to you, $name! 🥂 Happy Birthday!",
    "Happy Birthday, $name! Stay blessed! 🙏",
    "$name, you're legendary! Have a blast! 🎊",
    "Happy Birthday, $name! You're amazing! 💖",
    "$name, you rock! Happy Birthday! 🎸",
    "Happy Birthday, $name! Stay golden! ✨",
    "$name, you're awesome! Have a great day! 🌟",
    "Happy Birthday, $name! You're the best! 💯",
    "$name, you're a legend! Happy Birthday! 🏆",
    "Happy Birthday, $name! You're my favorite! ❤️",
    "$name, you're wonderful! Happy Birthday! 🌺",
    "Happy Birthday, $name! You're special! 🎁",
    "$name, you're the best! Have a blast! 🎉",

    // Funny (20 messages)
    "Happy Birthday, $name! Remember, you're not old, you're vintage! 🍷",
    "$name, you're aging like fine wine - slowly and expensively! 😂",
    "Happy Birthday, $name! You're not 30, you're 18 with 12 years of experience! 🎂",
    "$name, I'd make a joke about your age, but I don't want to be rude! 😉",
    "Happy Birthday, $name! You're so old, your candles cost more than your cake! 🕯️",
    "$name, you're not getting older, you're just downloading more updates! 📱",
    "Happy Birthday, $name! You're like a software update - necessary but annoying! 😂",
    "$name, congratulations on being born before smartphones were invented! 📱",
    "Happy Birthday, $name! You're not old, you're just retro! 🎮",
    "$name, I was going to count your candles, but I ran out of numbers! 🕯️",
    "Happy Birthday, $name! You're like a fine wine - a bit acidic but worth it! 🍷",
    "$name, you're not old, you're just a classic! 🎸",
    "Happy Birthday, $name! You're so old, you remember when Netflix sent DVDs! 📀",
    "$name, you're not aging, you're just becoming more expensive! 💰",
    "Happy Birthday, $name! You're like a cheese - stronger with age! 🧀",
    "$name, you're not getting older, you're just increasing in value! 💎",
    "Happy Birthday, $name! You're so old, you remember dial-up internet! 📞",
    "$name, congratulations on being born in the 1900s! 😂",
    "Happy Birthday, $name! You're not old, you're just experienced! 🎯",
    "$name, you're so old, your birthday is in BC - Before Cake! 🍰",

    // Romantic/Heartfelt (15 messages)
    "$name, you make every day feel like a celebration. Happy Birthday, my dear! 💕",
    "Happy Birthday, $name! Your smile lights up the darkest rooms! Keep shining! 🌟",
    "$name, you're the reason birthdays are special. Wishing you all the happiness! 💗",
    "On your birthday, $name, I just want to say - you are deeply loved! ❤️",
    "Happy Birthday, $name! Thank you for being the incredible person you are! 🙌",
    "$name, you're the beat in my heart and the smile on my face. Happy Birthday! 💖",
    "Happy Birthday, $name! You make my world brighter just by being in it! ☀️",
    "$name, you're the best thing that ever happened to me! Happy Birthday! 💕",
    "Happy Birthday, $name! You're the answer to my prayers! 🙏",
    "$name, you're the most beautiful soul I know! Happy Birthday! 🌹",
    "Happy Birthday, $name! You're the reason I believe in love! 💗",
    "$name, you're my sunshine on a rainy day! Happy Birthday! ☀️",
    "Happy Birthday, $name! You're the best part of my day, every day! 💖",
    "$name, you're the melody in my heart! Happy Birthday! 🎵",
    "Happy Birthday, $name! You're my forever and always! ❤️",

    // Poetic (15 messages)
    "$name, like a flower you bloom, filling the world with your perfume. Happy Birthday! 🌺",
    "Happy Birthday, $name! Another chapter in your beautiful story begins today! 📖",
    "$name, you're a masterpiece of joy and grace. Have a beautiful birthday! 🎨",
    "The world got brighter when you were born, $name. Happy Birthday! ☀️",
    "$name, your life is a gift to everyone who knows you. Celebrate YOU today! 🎁",
    "$name, like a star you shine bright, lighting up the darkest night! ⭐",
    "Happy Birthday, $name! You're poetry in motion! 📝",
    "$name, you're the song that never ends! Happy Birthday! 🎵",
    "Happy Birthday, $name! You're a beautiful soul in a beautiful world! 🌍",
    "$name, like a rainbow you color my world! Happy Birthday! 🌈",
    "Happy Birthday, $name! You're a dream come true! 💭",
    "$name, you're the calm in my storm! Happy Birthday! 🌊",
    "Happy Birthday, $name! You're the light in my life! ✨",
    "$name, you're the beauty in the chaos! Happy Birthday! 🎨",
    "Happy Birthday, $name! You're a masterpiece of love! 💖",

    // Pop Culture (10 messages)
    "Happy Birthday, $name! You're the main character of today's story! 🎬",
    "$name, you're the MVP of my life! Happy Birthday! 🏀",
    "Happy Birthday! $name, you're totally the GOAT! 🐐",
    "$name, you're a legend in your own mind! Happy Birthday! 🎮",
    "Happy Birthday, $name! You're the hero of your own movie! 🎥",
    "$name, you're the star of the show! Happy Birthday! ⭐",
    "Happy Birthday, $name! You're the king/queen of the world! 👑",
    "$name, you're the one who saves the day! Happy Birthday! 🦸",
    "Happy Birthday, $name! You're the GOAT of birthdays! 🐐",
    "$name, you're the main event! Happy Birthday! 🎪",

    // Encouraging (15 messages)
    "$name, keep being the amazing person you are. Happy Birthday! 🌈",
    "Happy Birthday, $name! Your journey is just beginning. Enjoy the ride! 🚗",
    "$name, the best is yet to come. Happy Birthday and cheers to new beginnings! 🥂",
    "Happy Birthday, $name! You've got this! This year is YOUR year! 💪",
    "$name, never forget how incredible you are. Happy Birthday! 🌟",
    "$name, you're destined for greatness! Happy Birthday! 🏆",
    "Happy Birthday, $name! You're stronger than you know! 💪",
    "$name, you can achieve anything! Happy Birthday! 🚀",
    "Happy Birthday, $name! Your potential is limitless! 🌟",
    "$name, you're unstoppable! Happy Birthday! 🔥",
    "Happy Birthday, $name! You're the best version of yourself! 🌈",
    "$name, the world is your oyster! Happy Birthday! 🦪",
    "Happy Birthday, $name! You're capable of amazing things! 💫",
    "$name, you're a winner! Happy Birthday! 🏅",
    "Happy Birthday, $name! You're a champion! 🏆",

    // Food-related (10 messages)
    "Happy Birthday, $name! May your cake be sweet and your joy even sweeter! 🍰",
    "$name, you're the icing on the cake of life! Happy Birthday! 🎂",
    "Happy Birthday, $name! Cheers to good food, good friends, and you! 🥗",
    "$name, you're sweeter than any birthday cake! Enjoy your day! 🧁",
    "Happy Birthday, $name! Time to feast and celebrate YOU! 🍕",
    "$name, you're the cherry on top! Happy Birthday! 🍒",
    "Happy Birthday, $name! You're the spice of life! 🌶️",
    "$name, you're the main course! Happy Birthday! 🍽️",
    "Happy Birthday, $name! You're the perfect recipe! 📖",
    "$name, you're the secret ingredient! Happy Birthday! 🧂"
];

// ========== SEASONAL MESSAGES ==========
$birthday_parts = explode('/', $birthday);
if (count($birthday_parts) === 2) {
    $month = (int)$birthday_parts[0];
    $day = (int)$birthday_parts[1];
    
    // Determine season
    $season = '';
    if (($month == 3 && $day >= 20) || ($month == 4) || ($month == 5) || ($month == 6 && $day < 21)) {
        $season = 'spring';
    } elseif (($month == 6 && $day >= 21) || ($month == 7) || ($month == 8) || ($month == 9 && $day < 23)) {
        $season = 'summer';
    } elseif (($month == 9 && $day >= 23) || ($month == 10) || ($month == 11) || ($month == 12 && $day < 21)) {
        $season = 'fall';
    } else {
        $season = 'winter';
    }
    
    $season_messages = [
        'spring' => "Happy Birthday, $name! Like spring, you bring new life and fresh energy! 🌸",
        'summer' => "$name, your birthday shines brighter than the summer sun! Happy Birthday! ☀️",
        'fall' => "Happy Birthday, $name! You're as beautiful as autumn leaves! 🍂",
        'winter' => "$name, you warm our hearts like a cozy winter fire! Happy Birthday! ❄️"
    ];
    
    // 30% chance to add a seasonal message
    if (rand(1, 100) <= 30) {
        $messages[] = $season_messages[$season];
    }
}

// ========== ZODIAC SIGN DETECTION ==========
$zodiac = '';
if (isset($month) && isset($day)) {
    if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) $zodiac = 'Aries ♈';
    elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) $zodiac = 'Taurus ♉';
    elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) $zodiac = 'Gemini ♊';
    elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) $zodiac = 'Cancer ♋';
    elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) $zodiac = 'Leo ♌';
    elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) $zodiac = 'Virgo ♍';
    elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) $zodiac = 'Libra ♎';
    elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) $zodiac = 'Scorpio ♏';
    elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) $zodiac = 'Sagittarius ♐';
    elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) $zodiac = 'Capricorn ♑';
    elseif (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) $zodiac = 'Aquarius ♒';
    elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) $zodiac = 'Pisces ♓';
}

// 20% chance to include zodiac
if ($zodiac && rand(1, 100) <= 20) {
    $messages[] = "Happy Birthday, $name! As a $zodiac, you're truly special! 🌟";
}

// ========== EMOJI COMBINATIONS ==========
$emoji_sets = [
    ['🎂', '🎉', '🎁'],
    ['💖', '✨', '🌟'],
    ['🎈', '🎊', '🥳'],
    ['🌺', '🌸', '💐'],
    ['🚀', '💫', '⭐'],
    ['💕', '💗', '❤️'],
    ['🎵', '🎶', '🎸'],
    ['🌈', '☀️', '🌟']
];

// Pick a random message
$random_index = array_rand($messages);
$message = $messages[$random_index];

// Add random emojis (10% chance to add extra)
if (rand(1, 100) <= 30) {
    $random_emojis = $emoji_sets[array_rand($emoji_sets)];
    $message .= " " . implode(' ', $random_emojis);
}

echo json_encode(['message' => $message]);
?>