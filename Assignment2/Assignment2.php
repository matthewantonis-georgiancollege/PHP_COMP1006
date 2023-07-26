<?php
/* 
Matthew Antonis 
200373088
COMP 1006
Assignment 2 
14/06/2023
*/

// Define the eligibility criteria. Each key represents a different criterion,
// and the value for each key is an array of acceptable values for that criterion.
$eligibility_criteria = array(
    'diploma' => array('CP', 'CS', 'CE'), // Acceptable diplomas
    'years_experience' => array('4','5','6'), // Acceptable years of experience
    'graduation_date' => array('2020','2021','2022'), // Acceptable graduation years
    'important_skill' => array('Java', 'PHP', 'Python'), // Acceptable skills
);

// Get user's background information. 
// Use readline() function to read the user input from the console.
$user_info = array(
    'diploma' => readline("Enter your diploma: "),
    'years_experience' => readline("Enter your years of experience: "),
    'graduation_date' => readline("Enter your graduation date: "),
    'important_skill' => readline("Enter an important skill: "),
);

// Assume the user is eligible at the start
$is_eligible = true;

// Iterate over each criterion in the eligibility criteria
foreach ($eligibility_criteria as $key => $value) {
    // Check if user's input for this criterion is in the array of acceptable values.
    // We use strtolower() on both sides to make the check case-insensitive.
    if (!in_array(strtolower($user_info[$key]), array_map('strtolower', $value))) {
        // If the user's input isn't acceptable, set $is_eligible to false and exit the loop.
        $is_eligible = false;
        break;
    }
}

// Output a message based on whether or not the user is eligible.
if ($is_eligible) {
    // If the user is eligible, congratulate them and tell them the interview date.
    echo "You are eligible for the job, your interview is in 1 week!\n";
} else {
    // If the user isn't eligible, inform them that other candidates are being considered.
    echo "We are sorry, we moved on with other candidates.\n";
}

?>
