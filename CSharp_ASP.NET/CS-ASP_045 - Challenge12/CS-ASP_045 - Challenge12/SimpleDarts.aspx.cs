using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_045___Challenge12
{
    public partial class SimpleDarts : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void okButton_Click(object sender, EventArgs e)
        {
            GameOf300 game = new GameOf300("Cindy","Susan");
            resultLabel.Text = game.PlayGame();
        }
    }
}