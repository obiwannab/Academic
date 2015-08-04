## C# and ASP.NET Projects
#### These are my solutions to the different "challenges" presented to us during the coursework at the Tech Academy.
The challenges come from Bob Tabor's *C# Fundamentals via ASP.NET Web Applications* video course on his website: www.learnvisualstudio.net.
##### *All of these folders contain my MS VisualStudio (2013 Community) solutions for the different challenges*

### Contents:
* __CS-ASP_051 - MegaChallenge2
    * simulation of the simple card game, War
    * the only user interaction is entering player names
    * the goal was to utilize mutliple classes to handle all the aspects of the game; my first attempt at separation of concerns.
    * I have program logic that determines if a player can continue to draw cards, however I have not handled exiting the predetermined 20 rounds if this happens before the rounds are up.
    * I utilized a Stack<T> collection for the different "decks" in the game which I thought would be a good fit with Push() and Pop().  However, I have not yet handled continuing the game by repopulating the players' hands with their winnings, which I could not implement because of the nature of the Stack<T> collection.
* __CS-ASP_045 - Challenge12
    * dart game (simple 300); no user interactivity
    * the goal was to create a separate library file with a class to use in the program logic
* __CS-ASP_036 - Challenge11part2__
    * character class for a simple game with battle logic
    * there is no interactivity here with the user
    * the goal was to work with classes to instantiate objects for use in program logic
* __CS-ASP_035 - Challenge10__
    * Four mini problems, all string manipulations:
        1. Reverse a string
        2. Reverse a sequence (array)
        3. Old school ASCII art with .PadLeft() and .PadRight()
        4. Remove, replace, and other manipulations on a single string
    * I took some notes in the middle of one of the problems, so the code is a little cluttered in that spot.
* __CS-ASP_034 - MegaChallenge1__
    * slot machine app
    * the goal was to incorporate several C# skills into a single application, including conditional logic, ViewState, and methods.
* __CS-ASP_034 - Challenge9__
    * postage calculator web app with an autopostback setting on field change
    * this was an exercise in utilizing methods
* __CS-ASP_023 - Challenge7__
    * web app for the fictitious spy agency to take new entries of asset activities
    * the goal here was to store information in the ViewState object for use between postback requests
* __CS-ASP_019 - Challenge6__
    * web app for a ficticous spy agency to make valid assignments of field agents
    * the goal was to make use of DateTime objects and TimeSpan objects
* __CS-ASP_013 - Challenge4__
    * web app for a ficticous online pizza ordering system
    * the goal was really about conditional logic, but I also included some simple validation and user feedback
* __CS-ASP_005 - Challenge1__
    * simple web app that takes the specified user input and delivers a "fortune"
    * I went a little above and beyond Mr. Tabor's specifications to include logic that changed the fortune based on the user's input
