using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_013___Challenge4
{
    public partial class PapaBobPizza : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void purchaseButton_Click(object sender, EventArgs e)
        {
            //Initialize
            totalLabel.Text = "$0.00";
            messageLabel.Text = "";
            double size = 0.0;
            double crust = 0.0;
            double toppings = 0.0;
            double discount = 0.0;
            double total = 0.0;
            bool selectSize = true;
            bool selectCrust = true;

            //Collect Customer Choices
            // *** Pizza Size *** //
            if (babySizeRadio.Checked) size = 10;
            else if (mamaSizeRadio.Checked) size = 13;
            else if (papaSizeRadio.Checked) size = 16;
            else selectSize = false;

            // *** Crust *** //
            if (thinCrustRadio.Checked) crust = 0;
            else if (deepCrustRadio.Checked) crust = 2;
            else selectCrust = false;
            
            // *** Toppings *** //
            if (pepperoniBox.Checked) toppings += 1.5;
            if (onionsBox.Checked) toppings += 0.75;
            if (greenPeppersBox.Checked) toppings += 0.50;
            if (redPeppersBox.Checked) toppings += 0.75;
            if (anchoviesBox.Checked) toppings += 2;

            //Check for Speacial Deal Discount
            if (pepperoniBox.Checked && ((greenPeppersBox.Checked && anchoviesBox.Checked)
                                            || (redPeppersBox.Checked && onionsBox.Checked)))
            {
                messageLabel.Text = "Papa Bob's Special!";
                discount = -2;
            }
            else discount = 0;

            //Check for valid choices
            // If customer does not select a size or a crust type, display error message and total of zero
            if (!selectSize && !selectCrust) messageLabel.Text = "Please select a size and crust for your Pizza.";
            else if (!selectSize) messageLabel.Text = "Please select a size for your Pizza.";
            else if (!selectCrust) messageLabel.Text = "Please select a type of crust for your Pizza.";
            else
            {
                total = size + crust + toppings + discount;
                totalLabel.Text = "$" + total.ToString();
                if (toppings == 0) messageLabel.Text = "Are you sure you don't want any toppings?";
            }
        }
    }
}