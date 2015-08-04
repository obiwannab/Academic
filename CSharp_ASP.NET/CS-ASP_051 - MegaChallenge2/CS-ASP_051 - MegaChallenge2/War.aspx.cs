using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_051___MegaChallenge2
{
    public partial class War : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void playButton_Click(object sender, EventArgs e)
        {
            string player1Name = player1NameTextBox.Text;
            string player2Name = player2NameTextBox.Text;
            GameOfWar game = new GameOfWar(player1Name, player2Name);
            resultLabel.Text = game.PlayGame();
        }
    }
}