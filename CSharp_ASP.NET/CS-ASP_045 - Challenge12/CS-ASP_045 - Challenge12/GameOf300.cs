using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Darts;

namespace CS_ASP_045___Challenge12
{
    public class GameOf300
    {
        private Player _player1;
        private Player _player2;
        private Dart _dart;
        private Random _random;

        public GameOf300()
        {
            //Initialize the Game
            this._random = new Random();
            this._dart = new Dart(_random);
            this._player1 = new Player();
            this._player2 = new Player();
        }

        public GameOf300(string player1Name, string player2Name) : this()
        {
            //Initialize the Game with player names given
            this._random = new Random();
            this._dart = new Dart(_random);
            this._player1.Name = player1Name;
            this._player2.Name = player2Name;
        }

        public string PlayGame()
        {
            //Game of 300
            while (this._player1.CurrentScore < 300 && this._player2.CurrentScore < 300)
            {
                //Each player gets a turn
                throwDarts(this._player1);
                throwDarts(this._player2);
            }
            return displayResults();
        }

        private string displayResults()
        {
            string results = "The results are in...<br />";
            results += String.Format("{0}'s score: {1}<br />", this._player1.Name, this._player1.CurrentScore.ToString());
            results += String.Format("{0}'s score: {1}<br />", this._player2.Name, this._player2.CurrentScore.ToString());
            if (this._player1.CurrentScore > this._player2.CurrentScore) results += "The winner of this match is " + this._player1.Name;
            else if (this._player2.CurrentScore > this._player1.CurrentScore) results += "The winner of this match is " + this._player2.Name;
            else results += "The match is a tie!";
            return results;
        }

        private void throwDarts(Player player)
        {
            //Each player gets to throw three darts
            int turnScore = 0;
            for (int i = 1; i <= 3; i++)
            {
                this._dart.ThrowDart();
                turnScore += Score.CalculateDartScore(this._dart);
            }
            player.CurrentScore += turnScore;  //Adjust the current player's score
        }

    }
}