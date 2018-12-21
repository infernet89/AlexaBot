<?php

// Include the library
require __DIR__ . '/alexa-endpoint/autoload.php';

/**
 * Import classes
 * Note, if there is already a class named 'User' in your scripts, use this:
 * use MayBeTall\Alexa\Endpoint\User as AlexaUser;
 * Then use 'AlexaUser' instead of 'User'.
 */
use MayBeTall\Alexa\Endpoint\Alexa;
use MayBeTall\Alexa\Endpoint\User;

// Sets everything up.
Alexa::init();

// User launched the skill.
Alexa::enters(function() {
	// Say something, wait for an answer, ask again if no reply is given
    //Alexa::ask('Ciao, come ti chiami?', "Scusa, quale è il tuo nome?");
	Alexa::say('<speak>Ma sapete cosa ho fatto?
Sapete cosa?
<prosody rate="110%">Sapete cosa ho chiesto, sapete cosa?</prosody>
<prosody rate="120%">Sapete cosa mi hanno dato, sapete cosa?</prosody>
<prosody rate="130%">Sapete cosa ho fatto, sapete cosa?</prosody>
<prosody rate="140%">Sapete cosa ho chiesto, sapete cosa? Sapete cosa mi hanno dato?</prosody>
<prosody rate="160%" pitch="-15%">Annulla, tralascia, riprova.</prosody>
<prosody rate="150%">Sapete cosa, sapete cosa ho fatto?</prosody>
<prosody rate="180%" pitch="-20%">Annulla, tralascia, riprova. Annulla, tralascia, riprova.</prosody>
<prosody rate="160%">Sapete cosa ho fatto?</prosody>
<prosody rate="165%" pitch="-25%">Annulla, tralascia, riprova.</prosody>
<prosody rate="170%">Sapete cosa ho chiesto?</prosody>
<prosody rate="120%" pitch="x-low"><say-as interpret-as="interjection">Annulla, tralascia</say-as></prosody>
<voice name="Giorgio">
<prosody rate="120%" pitch="-24%"><say-as interpret-as="interjection">, riprova.</say-as></prosody>
<prosody pitch="x-low">Mi hanno dato questo corpo di fibra di carbonio e leghe di metalli,
fibra ottica e <say-as interpret-as="interjection">sofisticati laminati plastici</say-as>, <break time="500ms"/> </prosody>
<prosody pitch="x-low" volume="x-loud">polimeriii,</prosody>
<prosody pitch="x-low"><emphasis level="strong">polimerii</emphasis>, meritatissimi polimeri!.</prosody></voice></speak>',true);
});

// User triggered the 'NameIntent' intent from the Skill Builder
User::triggered('NameIntent', function() {
	// Get the slot named 'name' sent by the Skill Builder
	$name = User::stated('name');

	// If user stated their name, continue
	if ($name) {
		// Remember the user's name
		Alexa::remember('name', $name);

		// Ask about coffee and use SSML to make Alexa sound mad if the user doesn't respond.
		// See https://developer.amazon.com/public/solutions/alexa/alexa-skills-kit/docs/speech-synthesis-markup-language-ssml-reference#emphasis
		Alexa::ask("Ciao $name, sono Alexa. Vuoi un caffè?",
			// Say something if the user doesn't respond
			'<speak>
				<say-as interpret-as="interjection">ahem</say-as>,
				Ho <emphasis level="reduced">detto</emphasis>,
				vorresti un caffè?
			</speak>'
		);
	} else {
		// If the user didn't say their name, say something then end the skill.
		Alexa::say("Ok, non dirmi il tuo nome.");
	}
});

// User triggered the 'CoffeeIntent' intent from the Skill Builder
User::triggered('CoffeeIntent', function() {
	// Get the 'answer' slot.
	$answer = User::stated('answer');

	// Get the name we remembered (if the user didn't skip directly to the coffee intent)
	$name = Alexa::recall('name');

	// If the user never gave a name, handle it by saying something else instead.
	if (!$name) {
		$name = "e non so nemmeno come ti chiami";
	}

	// If answer was provided.
	if ($answer) {
		if ($answer == 'yes') {
			// If user said yes.
			Alexa::say("Ottimo! Già mi piaci, $name.");
		} else {
			// If user said anything else.
			Alexa::say("No? Non mi fido di te, $name.");
		}
	} else {
		// If answer was not provided.
		Alexa::say("Okay, ciao!");
	}
});

// User exited the skill.
Alexa::exits(function() {
	/**
	 * Alexa will not say anything you send in reply, but it is important
	 * to have this here because she will give an error message if we
	 * don't acknowledge the skill's exit.
	 */
});
