<?php

// Represents a deck of cards
class Deck {
    public $cards;

    function __construct() {
        // Initialize an empty array for the cards
        $this->cards = [];

        // Define all possible suits and values
        $suits = ['spades', 'hearts', 'clubs', 'diamonds'];
        $values = range(2, 10);
        array_push($values, 'J', 'Q', 'K', 'A');

        // Create a deck with all combinations of suits and values
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = [$suit, $value];
            }
        }

        // Shuffle the deck
        shuffle($this->cards);
    }

    // Draw a card from the deck
    function drawCard() {
        return array_pop($this->cards);
    }
}

// Represents a player in the game
class Player {
    public $hand = [];  // The player's hand of cards
    public $money = 0;  // The player's money
    public $bet = 0;    // The current bet
    public $quit = false;  // Boolean to quit the game

    // Place a bet
    function placeBet($amount) {
        if ($amount <= $this->money) {
            $this->bet = $amount;
            $this->money -= $amount; // Subtract the bet from the player's money
        } else {
            echo "Not enough money to bet that amount!\n";
            return false;
        }
        return true;
    }

    // Receive a card from the deck
    function receiveCard($card) {
        $this->hand[] = $card;
    }

    // Calculate the value of the player's hand
    function handValue() {
        $total = 0;
        foreach ($this->hand as $card) {
            // Numerical cards are worth their number
            if (is_numeric($card[1])) {
                $total += $card[1];
            // Aces are worth 11
            } else if ($card[1] === 'A') {
                $total += 11;
            // Face cards are worth 10
            } else {
                $total += 10;
            }
        }
        return $total;
    }

    // Reset hand for a new round
    function resetHand() {
        $this->hand = [];
    }
}

// Function to welcome the player
function welcome(Player $player, Player $dealer) {
    echo "Welcome to the Casino!\n";
    echo "Player money: " . $player->money . "\n";
    echo "Dealer money: " . $dealer->money . "\n";
}


// Function to play the game
function playGame(Player $player, Player $dealer, Deck $deck) {
    // Reset hands at the start of the round
    $player->resetHand();
    $dealer->resetHand();

    // Draw initial cards for player and dealer
    $player->receiveCard($deck->drawCard());
    $dealer->receiveCard($deck->drawCard());

    // Player's turn
    while(!$player->quit) {
        // Display player's hand value and ask if they want to draw another card
        echo "Your hand value is " . $player->handValue() . "\n";
        echo "Do you want to draw another card? y/n\n";
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);
        if(trim($line) == 'n'){
            $player->quit = true;
            break;
        } 
        // If player chooses to draw, draw a card from deck and display it
        $card = $deck->drawCard();
        $player->receiveCard($card);
        echo "You drew a " . $card[1] . " of " . $card[0] . "\n";

        // Check if player has busted
        if ($player->handValue() > 21) {
            echo "You've busted! Game over.\n";
            $dealer->money += $player->bet;
            exit(0);
        }
    }

    // Dealer's turn (dealer keeps drawing until they have at least 17)
    while($dealer->handValue() < 17) {
        $dealer->receiveCard($deck->drawCard());
    }

    // Determine winner and adjust money accordingly
    if ($player->handValue() > 21) {
        echo "Player busts! Dealer wins!\n";
        $dealer->money += $player->bet;
    } else if ($dealer->handValue() > 21) {
        echo "Dealer busts! Player wins!\n";
        $player->money += 2*$player->bet;
    } else if ($player->handValue() > $dealer->handValue()) {
        echo "Player wins!\n";
        $player->money += 2*$player->bet;
    } else {
        echo "Dealer wins!\n";
        $dealer->money += $player->bet;
    }

    // Display remaining money
    echo "Player money: " . $player->money . "\n";
    echo "Dealer money: " . $dealer->money . "\n";
}

// Initialize player, dealer and deck
$player = new Player();
$dealer = new Player();
$deck = new Deck();

// Set initial money for player and dealer
$player->money = 1000;
$dealer->money = 1000;

// Start the game
welcome($player, $dealer);

// Main game loop
do {
    echo "How much would you like to bet?\n";
    $handle = fopen ("php://stdin","r");
    $betAmount = fgets($handle);
    if ($player->placeBet((int)$betAmount)) {
        playGame($player, $dealer, $deck);
    }

    // Ask player if they want to continue or quit
    echo "Would you like to play another round? y/n\n";
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if(trim($line) == 'n'){
        $player->quit = true;
    } else {
        $player->quit = false;
    }
} while (!$player->quit);

?>
