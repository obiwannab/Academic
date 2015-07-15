using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_023___Challenge7
{
    public partial class EpicSpiesAssetTracker : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            //Initialize and Declare arrays on first page load
            if (!Page.IsPostBack)
            {
                string[] assets = new string[0];
                int[] elections = new int[0];
                int[] subterfuge = new int[0];
                ViewState.Add("AssetArray", assets);
                ViewState.Add("ElectionsArray", elections);
                ViewState.Add("SubterfugeArray", subterfuge);
            }
        }

        protected void addAssetButton_Click(object sender, EventArgs e)
        {
            //Initialize variables and clear all the feedback fields
            string[] assets = (string[])ViewState["AssetArray"];
            int[] elections = (int[])ViewState["ElectionsArray"];
            int[] subterfuge = (int[])ViewState["SubterfugeArray"];
            int totalElections = 0;
            double avgActs = 0.0;
            nameFeedback.Text = "";
            electRiggFeedback.Text = "";
            actsSubterFeedback.Text = "";
            resultLabel.Text = "";

            //Validate user input
            if (nameTextBox.Text == "")
                { nameFeedback.Text = "Please enter the asset's name."; return; }
            else if (electRiggTextBox.Text == "")
                { electRiggFeedback.Text = String.Format("Please enter 0 if {0} did not rig any elections.", nameTextBox.Text); return; }
            else if (actsSubterTextBox.Text == "")
                { actsSubterFeedback.Text = String.Format("Please enter 0 if {0} did not perform any subterfuge.", nameTextBox.Text); return; }

            //Add Asset to the arrays and store in the ViewState
            Array.Resize(ref assets, assets.Length + 1);
            Array.Resize(ref elections, elections.Length + 1);
            Array.Resize(ref subterfuge, subterfuge.Length + 1);
            int newElement = assets.GetUpperBound(0);
            assets[newElement] = nameTextBox.Text;
            elections[newElement] = int.Parse(electRiggTextBox.Text);
            subterfuge[newElement] = int.Parse(actsSubterTextBox.Text);
            ViewState["AssetArray"] = assets;
            ViewState["ElectionsArray"] = elections;
            ViewState["SubterfugeArray"] = subterfuge;

            //Calculations
            totalElections = elections.Sum();
            avgActs = subterfuge.Average();

            //Display Results and clear the fields
            resultLabel.Text = String.Format("Total Elections Rigged: {0}<br />" +
                                             "Average Acts of Subterfuge per Asset: {1:N2}<br />" +
                                             "(Last Asset you Added: {2})",
                                             totalElections, avgActs, assets[newElement]);
            nameTextBox.Text = "";
            electRiggTextBox.Text = "";
            actsSubterTextBox.Text = "";
        }
    }
}