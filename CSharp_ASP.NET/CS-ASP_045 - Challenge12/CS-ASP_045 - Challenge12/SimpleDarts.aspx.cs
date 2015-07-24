using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Darts;

namespace CS_ASP_045___Challenge12
{
    public partial class SimpleDarts : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void okButton_Click(object sender, EventArgs e)
        {
            //Initialize the Game
            Random random = new Random();
            Dart dart = new Dart(random);
            int[] playerScores = new int[] { 0, 0, 0 };
            int turnScore = 0;
            string winner = "";

            //Game of 300
            while (playerScores[0] < 300)
            {
                //Each player gets a turn
                for (int player = 1; player < playerScores.Length; player++)
                {
                    //Each player gets to throw three darts
                    turnScore = 0;
                    for (int i = 1; i <= 3; i++)
                    {
                        dart.ThrowDart();
                        turnScore += Score.CalculateDartScore(dart);
                    }
                    playerScores[player] += turnScore;  //Adjust the current player's score
                }
                playerScores[0] = playerScores.Max();  //Find the highest score for the loop check
            }

            //Display the Results
            winner = String.Format("Player{0}", Array.IndexOf(playerScores, playerScores.Max(), 1));
            resultLabel.Text = "The results are in...<br />";
            for (int player = 1; player < playerScores.Length; player++)
                resultLabel.Text += String.Format("Player{0}'s score: {1}<br />", player, playerScores[player]);
            resultLabel.Text += "The winner of this match is " + winner;
        }
    }

    public static class Score
    {
        public static int CalculateDartScore(Dart dart)
        {
            int score = 0;
            //Is it a bullseye?
            if (dart.ThrowResult == 0) { return score = (dart.InnerRing) ? 50 : 25; }
            //If not, then is it in an Inner or Outer Ring?
            if (dart.InnerRing) { return score = dart.ThrowResult * 3; }
            else if (dart.OuterRing) { return score = dart.ThrowResult * 2; }
            else { return score = dart.ThrowResult; }
        }
    }
}