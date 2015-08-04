using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace CS_ASP_051___MegaChallenge2
{
    public class GameOfWar
    {
        private Player _player1;
        private Player _player2;
        private Random _random;
        private StandardDeck _gameDeck;

        public GameOfWar()
        {
            this._random = new Random();
            this._gameDeck = new StandardDeck(true);
            this._player1 = new Player("Player1");
            this._player2 = new Player("Player2");
        }
        public GameOfWar(string player1Name, string player2Name) : this()
        {
            this._player1.Name = player1Name;
            this._player2.Name = player2Name;
        }

        public string PlayGame()
        {
            //Shuffle the Main Game Deck and deal all the cards to the two players
            this._gameDeck.Shuffle(_random);
                        //string result = this.DisplayDeckDEBUG(this._gameDeck);  //DEBUG: want to see the contents of the deck
            this.DealCards();
            //Begin the Game
            string result = "Let's start the War!!!!!<br />";
            int round = 1;
            while (round <= 20)  //Only play for 20 rounds
            {
                result += String.Format("---Round {0}---<br />", round);
                result += Battle.StartBattle(this._player1, this._player2);
                result += "<br />";
                round++;
            }
            result += DetermineWinner();
            return result;
        }

        private void DealCards()
        {
            bool toggle = true;
            while (this._gameDeck.Deck.Count() > 0)
            {
                if (toggle)
                {
                    this._player1.Hand.Deck.Push(this._gameDeck.Deck.Pop());
                    toggle = false;
                }
                else
                {
                    this._player2.Hand.Deck.Push(this._gameDeck.Deck.Pop());
                    toggle = true;
                }
            }
        }

        private string DetermineWinner()
        {
            //Whoever has the most cards in their Discard Pile wins the game
            string winner = "";
            if (this._player1.Winnings.Count() > this._player2.Winnings.Count()) winner = _player1.Name + "!";
            else if (this._player1.Winnings.Count() < this._player2.Winnings.Count()) winner = _player2.Name + "!";
            else winner = "Neither!  The match is a draw!";
            //Display the Game Results
            string winnerResult = "The final tally...<br />";
            winnerResult += String.Format("&nbsp;&nbsp;&nbsp;{0} won {1} cards<br />",
                                          this._player1.Name, this._player1.Winnings.Count().ToString());
            winnerResult += String.Format("&nbsp;&nbsp;&nbsp;{0} won {1} cards<br />",
                                          this._player2.Name, this._player2.Winnings.Count().ToString());
            winnerResult += String.Format("And the winner is...{0}", winner);
            return winnerResult;
        }

        private string DisplayDeckDEBUG(StandardDeck stack)
        {
            string result = "Cards in Main Game Deck (Reverse Order)<br />";
            while (stack.Deck.Count() > 0)
            {
                Card card = stack.Deck.Pop();
                result += String.Format("{0} - {1}<br />", card.Name, card.Value.ToString());
            }
            return result;
        }

    }
}