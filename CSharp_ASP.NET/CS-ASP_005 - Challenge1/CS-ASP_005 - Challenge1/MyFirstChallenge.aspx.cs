using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_005___Challenge1
{
    public partial class MyFirstChallenge : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void fortuneButton_Click(object sender, EventArgs e)
        {
            // Initialize all the variables
            // C# will concatenate integers and doubles with strings by converting the numbers to strings first...
            int userAge = int.Parse(userAgeTextBox.Text);
            double userMoney = double.Parse(userMoneyTextBox.Text);
            string result = "";  // VisualStudio would not remove an error indicator unless I initialized this string

            if(userAge < 0) { result = "So...you haven't been born yet..."; }
            else if (userMoney < 0)
            { 
                double money = 0 - userMoney;  // Change to a positive number to display
                result = "$" + money + " is too much money to owe anyone at any age.";
            }
            else
            {
                if((userAge >= 0) && (userAge <= 5))
                {
                    if(userMoney == 0) { result = "Welcome to planet!"; }
                    else if(userMoney <= 5) { result = "I'm surprised you have any money at all in your pocket."; }
                    else { result = "With $" + userMoney + " in your pocket, you must also have a silver spoon!"; }
                }
                else if((userAge > 5) && (userAge <= 18))
                {
                    if(userMoney <= 20) { result = "At " + userAge + " years old, $" + userMoney + " is plenty of money to have in your pocket"; }
                    else if((userMoney > 20) && (userMoney <= 100)) { result = "Wow!  That's a lot of money to have in your pocket at only " + userAge + " years old!"; }
                    else { result = "Can you say...\"Trust Fund?\""; }
                }
                else if((userAge > 18) && (userAge < 100))
                {
                    if((userMoney >= 0) && (userMoney <= 50)) { result = "At " + userAge + " years old, I would have expected you to have more than $" + userMoney + " in your pocket."; }
                    else if((userMoney > 50) && (userMoney <= 100)) { result = "Perfect!  It is expected that a " + userAge + " year old have $" + userMoney + " in their pocket."; }
                    else { result = "Nice!  $" + userMoney + " will buy me a steak dinner."; }
                }
                else if(userAge >= 100)
                {
                    result = "You're " + userAge + " years old!  Does it really matter how much money you have?";
                }
                else { result = "Your future looks cloudy...I cannot see through the mists..."; }
            }

            labelTextBox.Text = result;
        }
    }
}