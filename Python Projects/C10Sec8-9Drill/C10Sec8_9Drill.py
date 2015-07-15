#!/user/bin/env
# Python Course
# Section 8 - Item #9
#   DRILL: db - Python 3.4
#       Required functionality...
#           Create Database that will store pre-made content for future use/reference within the GUI tool
#           User needs to be able to create new HTML file from entered content OR
#           User needs to be able to save entered content to the database as new pre-made content
#           User needs to be able to retrieve pre-made content from database and display in a grid
#           User needs to be able to select from displayed pre-made content and use that selection to create new HTML file
#
#       Future ideas...
#           Allow user to insert selected pre-made content into the text field at the current cursor mark
#           Allow user to insert new content to a pre-made selection by displaying the selection in the text field
#             and allowing the user to edit the content before creating the file or saving the selection
#           Adjust Datatbase so that each piece of pre-made content has a unique "name" with it
#           Allow user to save current contents of text field as pre-made content with a new "name"
#           Allow user to update a piece of pre-made content that already exists in database with current contents of text field
#
import sqlite3, os
from tkinter import *
from tkinter import ttk
from tkinter import messagebox
from tkinter import filedialog

class HTMLGUI():

    def __init__(self, master):
        # Initialize the Main Window Specs
        self._main_window = master
        self._main_window.title("Custom HTML File Tool")
        self._main_window.geometry("650x300+100+100")
        self._main_window.resizable(0,0)

        # Initialize the HTML Content variables
        self._htmlOpening = ["<html>",
                            "<body>"]
        self._htmlBody = []
        self._htmlClosing = ["</body>",
                            "</html>"]

        # Create the Main GUI Interface
        self.contentFrame = ttk.Frame(master)
        self.contentFrame.grid(row = 0, column = 0, padx = 5, pady = 5)
        ttk.Label(self.contentFrame, text = "Enter the BODY contents of the web page:").grid(row = 0, column = 0,
                                                                   columnspan = 2, padx = 5, pady = 5, sticky = "w")
        self.userContent = Text(self.contentFrame, width = 50, height = 13, wrap = "word")
        self.scrollUserContent = ttk.Scrollbar(self.contentFrame, orient = VERTICAL, command = self.userContent.yview)
        self.userContent.config(yscrollcommand = self.scrollUserContent.set)
        self.scrollUserContent.grid(row = 1, column = 1, sticky = "ns")
        self.userContent.grid(row = 1, column = 0, padx = 5, pady = 5)


        self.storageFrame = ttk.Frame(master)
        self.storageFrame.grid(row = 0, column = 1, padx = 5, pady = 5)
        ttk.Label(self.storageFrame, text = "Store contents as:").grid(row = 0, column = 0, padx = 5, pady = 5, sticky = "w")
        self.contentName = ttk.Entry(self.storageFrame, width = 35)
        self.contentName.grid(row = 1, column = 0, padx = 5, pady = 5, sticky = "w")
        ttk.Button(self.storageFrame, text = "Store Content", command = self._storeContent).grid(row = 2, column = 0,
                                                                                                 padx = 5, pady = 5)

        self.mainButtons = ttk.Frame(master)
        self.mainButtons.grid(row = 1, column = 0, columnspan = 2, padx = 5, pady = 5)
        ttk.Button(self.mainButtons, text = "Create File", command = self._createHTML).grid(row = 0, column = 0,
                                                                                       padx = 5, pady = 5)
        ttk.Button(self.mainButtons, text = "Clear", command = self._clearUserInput).grid(row = 0, column = 1,
                                                                                     padx = 5, pady = 5)
        ttk.Button(self.mainButtons, text = "Pre-Made", command = self._preMadeContent).grid(row = 0, column = 2,
                                                                                             padx = 5, pady = 5)
        ttk.Button(self.mainButtons, text = "Close", command = self._quit).grid(row = 0, column = 3,
                                                                                padx = 5, pady = 5)

        # Open a Connection to the Database for storing and retrieving content.
        self.db = sqlite3.connect("premadecontent.db")

    # Internal Functions
    def _preMadeContent(self):
        # Creates a new window for the user to select from stored content in the Database and use that content to
        #   make the HTML file from instead of user input.
        # Create the new window and populate the list from the Database
        self._preMadeWindow = Toplevel()
        self._preMadeWindow.title("Custom HTML File Tool | Pre-Made Content")
        self._preMadeWindow.geometry("600x300+150+150")
        self._preMadeWindow.resizable(0,0)
        self.listFrame = ttk.Frame(self._preMadeWindow)
        self.listFrame.grid(row = 0, column = 0, padx = 5, pady = 5)
        ttk.Label(self.listFrame, text = "Pre-Made Content").grid(row = 0, column = 0, padx = 5, pady = 5, sticky = "w")
        self.storedList = ttk.Treeview(self.listFrame, height = 8, selectmode = "browse")
        self.scrollStoredList = ttk.Scrollbar(self.listFrame, orient = VERTICAL, command = self.storedList.yview)
        self.storedList.config(yscrollcommand = self.scrollStoredList.set)
        self.scrollStoredList.grid(row = 1, column = 1, sticky = "ns")
        self.storedList.grid(row = 1, column = 0, padx = 5, pady = 5)
            # Query the database to retrieve the stored content names to populate the selection list
        self.itemsQueryResult = self.db.execute('SELECT id, name FROM storage ORDER BY id')
        self.itemsList = self.itemsQueryResult.fetchall()
        if not self.itemsList:  # Check for an empty list
            self.storedList.insert("", "0", "0", text = "No Stored Content Found...")
        else:
            for id, name in self.itemsList:
                self.storedList.insert("", "end", id, text = name)

        self.prevFrame = ttk.Frame(self._preMadeWindow)
        self.prevFrame.grid(row = 0, column = 1, padx = 5, pady = 5)
        ttk.Label(self.prevFrame, text = "Preview").grid(row = 0, column = 0, padx = 5, pady = 5)
        self.previewContent = Text(self.prevFrame, width = 40, height = 10, wrap = "word", state = "disabled")
        self.scrollPreview = ttk.Scrollbar(self.prevFrame, orient = VERTICAL, command = self.previewContent.yview)
        self.previewContent.config(yscrollcommand = self.scrollPreview.set)
        self.scrollPreview.grid(row = 1, column = 1, sticky = "ns")
        self.previewContent.grid(row = 1, column = 0, padx = 5, pady = 5)

        self.preMadeWinButtons = ttk.Frame(self._preMadeWindow)
        self.preMadeWinButtons.grid(row = 1, column = 0, columnspan = 2, padx = 5, pady = 5)
        ttk.Button(self.preMadeWinButtons, text = "Preview",
                                      command = self._previewFromStored).grid(row = 0, column = 0, padx = 5, pady = 5)
        ttk.Button(self.preMadeWinButtons, text = "Create File",
                                      command = self._HTMLFromStored).grid(row = 0, column = 1, padx = 5, pady = 5)
        ttk.Button(self.preMadeWinButtons, text = "Close",
                                      command = self._closeStoredWin).grid(row = 0, column = 2, padx = 5, pady = 5)
        ttk.Button(self.preMadeWinButtons, text = "Quit",
                                      command = self._quit).grid(row = 0, column = 3, padx = 5, pady = 5)

    def _storeContent(self):
        # Takes user's input in Text field and saves it in Database with the specified name
        # First, check that there is a name entered in the Entry field and there is content in the Text field
        if len(self.contentName.get()) == 0:
            messagebox.showinfo(title = "Custom HTML File Tool | Oops...", message = """
            Please enter a name for the custom content to be stored under.""")
            return
        elif len(self.contentName.get()) > 30:  # also Verify that name is less than or equal to 30 characters
            messagebox.showinfo(title = "Custom HTML File Tool | Oops...", message = """
            Sorry...the entered name is too long.
            Please enter a name that is 30 characters or less.""")
            return
        elif len(self.userContent.get("1.0", "end")) == 1:
            self._confirmStorage = messagebox.askyesno(title = "Custom HTML File | Confirm",
                                                       message = """
            There is no content currently entered into the Text Field.
            Are you sure you want to continue with the storage process?""")
            if self._confirmStorage != True: return

        # Next, access the database, check for the name; if name already exists, confirm the update of record with the user
        self.checkResult = self.db.execute('SELECT * FROM storage WHERE name = ? LIMIT 1', (self.contentName.get(),))
        self.nameExists = self.checkResult.fetchone()
        if self.nameExists:
            self._confirmUpdate = messagebox.askyesno(title = "Custom HTML File | Confirm",
                                                    message = """
            There is custom content already stored under the name \"{}\".
            Would you like to overwrite this content?""".format(self.contentName.get()))
            if not self._confirmUpdate: return
            else:
                self.db.execute('UPDATE storage SET content = ? WHERE name = ?',
                                (self.userContent.get("1.0", "end"), self.contentName.get()))
                self.db.commit()
                messagebox.showinfo(title = "Custom HTML File Tool | Complete", message = """Content Updated.""")
                self._clearUserInput()
                self.contentName.delete(0, END)
                return

        # Finish, store the new content to the Database (unless there was an update for an existing record)
        self.db.execute('INSERT INTO storage (name, content) VALUES (?, ?)',
                        (self.contentName.get(), self.userContent.get("1.0", "end")))
        self.db.commit()
        messagebox.showinfo(title = "Custom HTML File Tool | Complete", message = """Content has been stored.""")
        self._clearUserInput()
        self.contentName.delete(0, END)

    def _previewFromStored(self):
        # Displays the currently selected item from the List of Stored Content
        # First, check that the user made a selection
        if not self._didUserMakeSelection(): return

        # Then, clear the preview pane
        self.previewContent.config(state = "normal")
        self.previewContent.delete("1.0", "end")

        # Next, query the Database using the id from the selected item; retrieve the stored content
        self.contentResult = self.db.execute('SELECT content FROM storage WHERE id = ? LIMIT 1',
                                             (self.storedList.selection()[0],))  # This query yields the content from the database...

        # Finish by displaying the stored content in the disabled Text field
        self.previewContent.insert("1.0", self.contentResult.fetchone()[0])
        self.previewContent.config(state = "disabled")

    def _didUserMakeSelection(self):
        # Check that the user has made a selection from the list; returns a boolean
        if self.storedList.selection: return True
        else:
            messagebox.showinfo(title = "Custom HTML File Tool | Oops...", message = """
            No content selected.
            Please make a selection from the list of Pre-Made Content.""")
            return False

    def _HTMLFromStored(self):
        # Creates an HTML file using the stored content from the selected item
        # First, check that the user has made a selection from the list
        if not self._didUserMakeSelection(): return

        # Also, get a filename from the user for file creation.
        self._customFileName = filedialog.asksaveasfilename(title = "Custom HTML File Tool | Save As...",
                                                            initialdir = "C:\\Users\\students\\Desktop",
                                                            initialfile = "custom", defaultextension = ".html")
        
        # Next, check if database has already been queried (i.e. is there content on display in the preview...)
        #   if no content on display, then query the database and retrieve the stored content
        if self.previewContent.get("1.0", "end") == 1:
            self.contentResult = self.db.execute('SELECT content FROM storage WHERE id = ? LIMIT 1',
                                                 (int(self.storedList.selection()[0]),))  # This query yields the content from the database...
            self._htmlBody = self.content.fetchone()[0].split("\n")
        else:
            self._htmlBody = self.previewContent.get("1.0", "end").split("\n")

        # Then, perform the file creation process
        for index, string in enumerate(self._htmlBody):
            self._htmlBody[index] = string + "<br />"

        # Loop through the content and create the HTML file
        self._htmlContent = self._htmlOpening + self._htmlBody + self._htmlClosing
        self._outfile = open(self._customFileName, "w")
        for line in self._htmlContent:
            print(line, file = self._outfile, end = "\n")
        
        # Finish with user feedback popup message
        messagebox.showinfo(title = "Custom HTML File | Complete",
                            message = """HTML file created. Script complete.""")
        self._closeStoredWin()

    def _createHTML(self):
        # Creates an HTML file from the user's input
        # First, check for user input; if TextBox is blank, issue a confirmation popup message
        if len(self.userContent.get("1.0", "end")) == 1:
            self._confirmCreate = messagebox.askyesno(title = "Custom HTML File | Confirm",
                                                    message = """
            There is no content currently entered into the Text Field.
            Are you sure you want to continue with the file creation?""")
            if self._confirmCreate != True: return

        # Also, get a filename from the user for file creation.
        self._customFileName = filedialog.asksaveasfilename(title = "Custom HTML File Tool | Save As...",
                                                            initialdir = "C:\\Users\\students\\Desktop",
                                                            initialfile = "custom", defaultextension = ".html")
        
        # Next, create body content list of strings from user input; add line break tags at end of each new line char
        self._htmlBody = self.userContent.get("1.0", "end").split("\n")
        for index, string in enumerate(self._htmlBody):
            self._htmlBody[index] = string + "<br />"

        # Loop through the content and create the HTML file
        self._htmlContent = self._htmlOpening + self._htmlBody + self._htmlClosing
        self._outfile = open(self._customFileName, "w")
        for line in self._htmlContent:
            print(line, file = self._outfile, end = "\n")
        
        # Finish with user feedback popup message
        messagebox.showinfo(title = "Custom HTML File | Complete",
                            message = """HTML file created. Script complete.""")

    def _clearUserInput(self):
        # Clear all of the user's content from the TextBox
        self.userContent.delete("1.0", "end")
        # Reinitialize the customizable content variable
        self._htmlBody = []

    def _closeStoredWin(self):
        # Closes the Pre-Made Content Window
        self._preMadeWindow.destroy()
        # Reinitialize the stored content variable
        self._contentStored = []

    def _quit(self):
        # Close the Database connection
        #self.db.close()
        # Exit the Main GUI
        self._main_window.destroy()
        

def main():

    root = Tk()
    app = HTMLGUI(root)
    root.mainloop()

if __name__ == "__main__": main()