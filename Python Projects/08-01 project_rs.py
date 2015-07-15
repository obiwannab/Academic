#!/user/bin/env
### Python Course ###
# Python GUI Development with Tkinter with Barron Stone, lynda.com
# Chapter 8: Building an Application
# Lesson 1: Defining Project Requirements (and my attempt before rest of lessons...)
#
# Client is the fictional "Explore California" tour company: http://www.explorecalifornia.org
# Project is to create a feedback form for customers that have taken the Desert to Sea Tour
#  to leave comments about their experience.
# Survey Form Requirements:
#   1. It will display a logo and instructions to user.
#   2. It will have user input fields for:
#       Name, Email Address, Multiline Commnets
#   3. It will have two buttons:  Submit and Clear
#   4. Pressing Submit will:
#       Print contents of input fields to the console.
#       Empty content of input field
#       Notify the user that comments were submitted.
#   5. Pressing Clear will:
#       Empty the input fields.
# Use the template that sets up a conventional implementation, where the GUI is a class.
#  You'll need to complete the __init__ constructor definition and define any other methods you
#  require.
#
from tkinter import *
from tkinter import ttk

class Feedback():

    def __init__(self, master):
        # Disable window resizing
        self._top_window = master
        self._top_window.resizable(0,0)

        # Create and Display Logo and Survey Labels
        self.logo = ttk.Label(master)
        self._pic = PhotoImage(file = "C:\\Users\\student\\Desktop\\Student Work\\Programs\\C10 Python\\Python GUI Dev Tkinter\\tour_logo.gif")
        self.logo.img = self._pic
        self.logo.config(image = self.logo.img)
        self.logo.grid(row = 0, column = 0, padx = 5, pady = 5, sticky = "nsew")
        ttk.Label(master, text = """The instructions for the user go here.........""").grid(row = 0, column = 1, padx = 5, pady = 5)
        ttk.Label(master, text = "Name:", justify = RIGHT).grid(row = 1, column = 0, sticky = "e", padx = 5, pady = 5)
        ttk.Label(master, text = "Email:", justify = RIGHT).grid(row = 2, column = 0, sticky = "e", padx = 5, pady = 5)
        ttk.Label(master, text = "Comments:", justify = RIGHT).grid(row = 3, column = 0, sticky = "ne", padx = 5, pady = 5)

        # Create and Layout Survey Entry Fields
        self.nameEntry = ttk.Entry(master, width = 50)
        self.nameEntry.grid(row = 1, column = 1, padx = 5, pady = 5)
        self.emailEntry = ttk.Entry(master, width = 50)
        self.emailEntry.grid(row = 2, column = 1, padx = 5, pady = 5)
        self.commentField = Text(master, width = 38, height = 10, wrap = "word")
        self.scrollbar = ttk.Scrollbar(master, orient = VERTICAL, command = self.commentField.yview)
        self.commentField.config(yscrollcommand = self.scrollbar.set)
        self.scrollbar.grid(row =3, rowspan = 3, column = 2, sticky = "ns")
        self.commentField.grid(row = 3, rowspan = 3, column = 1, padx = 5, pady = 5)
        ttk.Button(master, text = "Submit", command = self._submit).grid(row = 4, column = 0, padx = 5, pady = 5, sticky = "s")
        ttk.Button(master, text = "Clear", command = self._clear).grid(row = 5, column = 0, padx = 5, pady = 5, sticky = "n")

    # Internal Functions
    def _submit(self):
        # Display User Input
        print("Customer Name: ", self.nameEntry.get())
        print("Customer Email: ", self.emailEntry.get())
        print("Comments: ", self.commentField.get("1.0", "end"))

        # Clear Entry Fields
        self._clear()

        # Notify User that Comments were Submitted
        messagebox.showinfo(title = "Explore California | Feedback - Submit",
                            message = """
        Thank you for taking the time to send us your feedback.
        Your comments were submitted and received.""")

    def _clear(self):
        # Clear all of the Text from the Entry Fields
        self.nameEntry.delete(0, END)
        self.emailEntry.delete(0, END)
        self.commentField.delete("1.0", "end")


def main():

    root = Tk()
    feedback = Feedback(root)
    root.mainloop()

if __name__ == "__main__": main()
