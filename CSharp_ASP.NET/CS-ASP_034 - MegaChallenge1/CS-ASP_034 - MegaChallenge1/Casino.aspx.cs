using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_034___MegaChallenge1
{
    public partial class Casino : System.Web.UI.Page
    {
        //Initialize global variables
           //imageArray stores the name of the images to display randomly
        string[] imageArray = new string[12] { "Bar", "Bell", "Cherry", "Clover", "Diamond", "HorseShoe", "Lemon", "Orange", "Plum", "Seven", "Strawberry", "Watermellon" };
        Random random = new Random();  //Creates a random number object for generating images

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!Page.IsPostBack)
            {
                //Initialize the page with images and the player's starting money
                spinSlotMachine();
                double playerMoney = 100.0;
                ViewState.Add("Player Money", playerMoney);
                resultLabel.Text = "";
                moneyLabel.Text = String.Format("Player's Money: {0:C}", playerMoney);
            }
        }

        protected void pullButton_Click(object sender, EventArgs e)
        {
            //1. Validate the user's bet
            if (!validBet()) return;  //Future Expansion: What if player's money is $0 or less?

            //2. Generate 3 random images
            spinSlotMachine();

            //3. Check for win or loss conditions
            int multiplier;
            double winnings;
            double playerMoney = (double)ViewState["Player Money"];
            double playerBet = double.Parse(playerBetTextBox.Text.Trim());
            bool playerWin = getWinCondition(out multiplier);

            //4. Resolve the Bet
            winnings = playerBet * multiplier;

            //5. Calculate the player's current money
            playerMoney = playerMoney + winnings - playerBet;

            //6. Display results
            if (playerWin) displayResult(winnings, playerBet, playerMoney);
            else displayResult(winnings, playerMoney);
            
            //7. Store player's current money for postback
            ViewState["Player Money"] = playerMoney;
            
        }

        private bool getWinCondition(out int multiplier)
        {   /* no parameters
             * Returns a boolean
             * Output: integer for winnings multiplier
             * This method will check the currently displayed slot machine images for a winning condition. */
            if (!playerHitBar())
            {
                if (playerHitJackpot()) { multiplier = 100; return true; }
                else
                {
                    int numberOfCherries = howManyCherries();
                    switch (numberOfCherries)
                    {
                        case 0: multiplier = -1; return false;
                        case 1: multiplier = 2; return true;
                        case 2: multiplier = 3; return true;
                        case 3: multiplier = 4; return true;
                        default: multiplier = -1; return false; //should never come up...
                    }
                }
            }
            else
            {
                multiplier = -1;
                return false;
            }
        }

        private int howManyCherries()
        {   /* no parameters
             * Return: the number of cherry images currently being displayed */
            int numberOfCherries = 0;
            string[] currentImages = new string[3];  //There should only be 3 images displayed
            currentImages = getCurrentImages();
            for (int i = 0; i < 3; i++) { if (currentImages[i] == "\\Images\\Cherry.png") numberOfCherries += 1; }
            return numberOfCherries;
        }

        private bool playerHitJackpot()
        {   /* no parameters
             * Returns a true boolean only if three sevens are currently being displayed */
            string[] currentImages = new string[3];  //There should only be 3 images displayed
            currentImages = getCurrentImages();
            if (currentImages[0] == "\\Images\\Seven.png" && currentImages[1] == "\\Images\\Seven.png" && currentImages[2] == "\\Images\\Seven.png")
                return true;
            else return false;
        }

        private bool playerHitBar()
        {   /* no parameters
             * Returns a true boolean only if any of the images currently being displayed is a bar */
            string[] currentImages = new string[3];  //There should only be 3 images displayed
            currentImages = getCurrentImages();
            for (int i = 0; i < 3; i++) { if (currentImages[i] == "\\Images\\Bar.png") return true; }
            return false;
        }

        private string[] getCurrentImages()
        {   /* no parameters
             * Return:  an array containing the names of three images currently being displayed */
            string[] currentImages = new string[3]; 
            for (int i = 0; i < 3; i++)
            {
                string controlID = "Image" + (i + 1).ToString();
                Image imageControl = FindControl(controlID) as Image;
                currentImages[i] = imageControl.ImageUrl;
            }
            return currentImages;
        }

        private bool validBet()
        {   /* no parameters
             * Returns a boolean 
             * =======================
             * Validation: 1. user input must be numeric
             *    (Future expansion 2. numeric input must be less than or equal to current money) */
            double bet;
            if (playerBetTextBox.Text.Trim() == "")
            {
                betFeedback.Text = "Please place a bet...";
                return false;
            }
            else if (!double.TryParse(playerBetTextBox.Text.Trim(), out bet))
            {
                betFeedback.Text = "Please enter a numerical bet...";
                return false;
            }
            else
            {
                betFeedback.Text = "";
                return true;
            }
        }

        private void displayResult(double winnings, double playerBet, double playerMoney)
        {   /* Required:  the amount of the winnings the player won
             *            the value of the player's bet
             *            the current amount of money the player has
             * no return
             * This will display the results of the current spin to the user. */
            resultLabel.Text = String.Format("You bet {0:C} and won {1:C}!", playerBet, winnings);
            moneyLabel.Text = String.Format("Player's Money: {0:C}", playerMoney);
        }

        private void displayResult(double winnings, double playerMoney)
        {   /* Required:  the amount of winnings the player won
             *            the current amount of money the player has
             * no return
             * This will display the results of the current spin to the user. */
            double loss = 0 - winnings;  //changes the negative winnings back to positive for correct display
            resultLabel.Text = String.Format("Sorry, you lost {0:C}.  Better luck next time.", loss);
            moneyLabel.Text = String.Format("Player's Money: {0:C}", playerMoney);
        }

        private void spinSlotMachine()
        {   /* no parameters, no return
             * This method will generate three random images and display them */
            for (int i = 0; i < 3; i++)
			{
			    int index = random.Next(0, 11);
                string imageName = imageArray[index];
                displayImage(imageName, i + 1);
			}
        }

        private void displayImage(string imageName, int i)
        {   /* Required:  the name of the image to display
             *            an integer indicating which image control to display the image in 
             * no return
             * This method will display the image into the specified image control...*/
            string controlID = "Image" + i.ToString();
            Image imageControl = FindControl(controlID) as Image;
            imageControl.ImageUrl = "\\Images\\" + imageName + ".png";
        }

    }
}