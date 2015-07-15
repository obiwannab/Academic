using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_034___Challenge9
{
    public partial class PostalCalculatorMethods : System.Web.UI.Page
    {
        //Initialize Feedback Fields
        /* no parameters
             * no return */
        private void initializeFeedback()
            {
                widthFeedback.Visible = false;
                lengthFeedback.Visible = false;
                shippingFeedback.Visible = true;
                resultLabel.Text = "";
            }

        //Check for width
        /* no parameters
             * Return: boolean */
        private bool widthEntered()
            {
                if(widthTextBox.Text == "")
                {
                    widthFeedback.Visible = true;
                    return false;
                }
                else
                {
                    widthFeedback.Visible = false;
                    return true;
                }
            }

        //Check for length
        /* no parameters
             * Return: boolean */
        private bool lengthEntered()
            {
                if(lengthTextBox.Text == "")
                {
                    lengthFeedback.Visible = true;
                    return false;
                }
                else
                {
                    lengthFeedback.Visible = false;
                    return true;
                }
            }
        
        //Get shipping multiplier based on user selection
        /* no parameters
         * Return: bool
         * Out: double shippingMultiplier */
        private bool getShippingMultiplier(out double multiplier)
        {
            multiplier = 0.0;
            if (groundRadioButton.Checked) 
            { 
                multiplier = .15;
                shippingFeedback.Visible = false;
                return true; 
            }
            else if (airRadioButton.Checked) 
            { 
                multiplier = .25;
                shippingFeedback.Visible = false;
                return true; 
            }
            else if (nextDayRadioButton.Checked) 
            { 
                multiplier = .45;
                shippingFeedback.Visible = false;
                return true; 
            }
            else 
            { 
                shippingFeedback.Visible = true; 
                return false; 
            }
        }

        //Calculate postage
        /* Parameters:  double shippingMultiplier
             *              double length required
             *              double width required
             *              double height optional
             * Return: double postage*/
        private double calculatePostage(double shippingMultiplier, double length, double width, double height = 1)
            {
                double volume = length * width * height;
                double postage = volume * shippingMultiplier;
                return postage;
            }

        //Display shipping results
        /* Parameters:  double postage
             * no return */
        private void displayShipping(double postage)
            {
                resultLabel.Text = String.Format("Your parcel will cost {0:C} to ship.", postage);
            }

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!Page.IsPostBack)
            {
                //Initialize Feedback
                initializeFeedback();
            }

            //Identify shipping multiplier and initialize variables
            double postage = 0.0;
            double shippingMultiplier = 0.0;
            if (getShippingMultiplier(out shippingMultiplier))
            {
                //Check for required information
                if (lengthEntered() && widthEntered())
                {
                    double length = double.Parse(lengthTextBox.Text);
                    double width = double.Parse(widthTextBox.Text);

                    //Check for optional information
                    if (heightTextBox.Text == "")
                    {
                        postage = calculatePostage(shippingMultiplier, length, width);
                    }
                    else
                    {
                        double height = double.Parse(heightTextBox.Text);
                        postage = calculatePostage(shippingMultiplier, length, width, height);
                    }

                    //Display postage to user
                    displayShipping(postage);
                }
                else resultLabel.Text = "";
            }
        }
    }
}