using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace CS_ASP_019___Challenge6
{
    public partial class EpicSpiesAssignment : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            /* Business Rule #1: 
             * Initialize the calendar controls.  Make sure the end of the previous assignment date is
             *  set to today.  Make sure the start date of the new assignment is set for an additional
             *  14 days from today.  Make sure the end date of the new assignment is set for an
             *  additional 21 days from today. */
            //Initialize the Calendar on first load
            if (!Page.IsPostBack)
            {
                prevAssignEndCalendar.SelectedDate = DateTime.Now.Date;
                newAssignStartCalendar.SelectedDate = DateTime.Now.Date.AddDays(14);
                newAssignEndCalendar.SelectedDate = DateTime.Now.Date.AddDays(21);
            }
        }

        protected void assignSpyButton_Click(object sender, EventArgs e)
        {
            //Initialize feedback and calculation variables
            resultLabel.Text = "";
            string message = "";
            TimeSpan timeOff = TimeSpan.Parse("0");
            TimeSpan assignLength = TimeSpan.Parse("0");
            double budget = 0.0;

            //Collect user input and selections
            string codename = codeNameTextBox.Text;
            string assignment = assignmentTextBox.Text;
            DateTime prevAssignEndDate = prevAssignEndCalendar.SelectedDate;
            DateTime newAssignStartDate = newAssignStartCalendar.SelectedDate;
            DateTime newAssignEndDate = newAssignEndCalendar.SelectedDate;
            
            // *** Main Process:
            // *** Check for valid dates
            // ***   if not, then display an error message
            // ***   if so, then calculate the budget
            if ((prevAssignEndDate < newAssignStartDate) && (newAssignStartDate < newAssignEndDate))
            {
                /* Business Rule #2:
                 * The United Spy Workers Union dictates there must be at least two weeks of paid time
                 *  between assignments.  If at least two weeks are not selected between the previous 
                 *  assignment and the new assignment, display an error message (see mockup #3).  Also,
                 *  show the manager the earliest available date on the calendar by selecting and showing that
                 *  date in the "Start of New Assignment" Calendar. */
                timeOff = newAssignStartDate.Subtract(prevAssignEndDate);
                if (timeOff.Days < 14)
                {
                    message = "Assignment is <b>not</b> authorized.<br />" +
                              "You must allow at least two weeks between previous assignment and new assignment.";
                    newAssignStartCalendar.SelectedDate = prevAssignEndCalendar.SelectedDate.Date.AddDays(14);
                    newAssignStartCalendar.VisibleDate = prevAssignEndCalendar.SelectedDate.Date.AddDays(14);
                    newAssignEndCalendar.SelectedDate = newAssignStartCalendar.SelectedDate.Date.AddDays(7);
                    newAssignEndCalendar.VisibleDate = newAssignStartCalendar.SelectedDate.Date.AddDays(7);
                }
                else
                {
                    //Calculating the budget
                    /* Business Rule #3:
                     * Spies cost $500 per day against your Assignment's budget.  Display the budget to the
                     *  manager in text at the bottom of the web page (see mockup #2). */
                    assignLength = newAssignEndDate.Subtract(newAssignStartDate);
                    budget = assignLength.TotalDays * 500;

                    /* Business Rule #4:
                     * If the assignment is greater than three weeks, an additional $1,000 budget fee
                     *  will be assessed. */
                    if (assignLength.Days > 21) budget += 1000;

                    //Feedback message of authorized assignment
                    message = String.Format("Assignment of {0} to assignment {1} is authorized.<br />" +
                                            "Budget total for this assignment: {2:C}", codename, assignment, budget);
                }

            }
            else if (newAssignEndDate < newAssignStartDate) message = "Assignment is <b>not</b> authorized.<br />" +
                                                 "New assignment ending date cannot be before its starting date.";
            else message = String.Format("Assignment is <b>not</b> authorized.<br />" +
                                         "{0} cannot be assigned to more than one project at a time.", codename);

            //Display message as feedback to user
            resultLabel.Text = message;
        }

        protected void prevAssignEndCalendar_SelectionChanged(object sender, EventArgs e)
        {
            prevAssignEndLabel.Text = prevAssignEndCalendar.SelectedDate.ToLongDateString();
        }

        protected void newAssignStartCalendar_SelectionChanged(object sender, EventArgs e)
        {
            newAssignStartLabel.Text = newAssignStartCalendar.SelectedDate.ToLongDateString();
        }

        protected void newAssignEndCalendar_SelectionChanged(object sender, EventArgs e)
        {
            newAssignEndLabel.Text = newAssignEndCalendar.SelectedDate.ToLongDateString();
        }
    }
}