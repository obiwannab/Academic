#!/user/bin/env
# Python Course
# Section 8 - Item #7
# DRILL: functionality for File Transfer - Python 3.4
#   Desired features--
#     Need to create a database to record the last time the file check/transfer took place
#     Need to display the last date and time the flie check/transfer was perform to the GUI
#     Need to use the last date and time as the reference point for checking for new or modified files
#   (this drill is EXACTLY the same as Item #5 DRILL...thus it is a similar solution, but written with
#     tKinter and Python 3.4 instead...)
#
import os, shutil, datetime, time, sqlite3
from tkinter import *
from tkinter import ttk
from tkinter import filedialog

class userUtil():
    def __init__(self, master):
        #self.frame = ttk.Frame(master, height = 300, width = 600, relief = RIDGE)
        #self.frame.pack()

        # Create Buttons for user to select directories and execute the transfer
        ttk.Button(master, text = "Source Directory",
                   command = self.chooseSrcDir).grid(row = 0, column = 0, padx = 5, pady = 5, ipadx = 16)
        ttk.Button(master, text = "Destination Directory",
                   command = self.chooseDestDir).grid(row = 1, column = 0, padx = 5, pady = 5, ipadx = 5)
        self.transferButton = ttk.Button(master, text = "Transfer Files", command = self.transferScript)
        self.transferButton.grid(row = 2, column = 0, padx = 5, pady = 5, ipadx = 26)
        self.transferButton.state(["disabled"])

        # Initialize Directory variables and Label variables
        self._source = StringVar()
        self._source.set("")
        self._destination = StringVar()
        self._destination.set("")
        self._feedback = StringVar()
        self._feedback.set("")
        self._previous = StringVar()
        self._previous.set("")

        # Create Labels to display user's selections from dialogues and last transfer info
        ttk.Label(master, textvariable = self._source).grid(row = 0, column = 1, padx = 5, pady = 5)
        ttk.Label(master, textvariable = self._destination).grid(row = 1, column = 1, padx = 5, pady = 5)
        ttk.Label(master, textvariable = self._feedback).grid(row = 2, rowspan = 3, column = 1,
                                                              padx = 5, pady = 5, sticky = "nw")
        ttk.Label(master, text = "Last Check/Transfer On:").grid(row = 3, column = 0,
                                                                 padx = 5, pady = 5, sticky = "nw")
        ttk.Label(master, textvariable = self._previous).grid(row = 4, column = 0, padx = 5, pady = 5, sticky = "nw")

        # Connect to reference database and display most recent transfer date
        self.db = sqlite3.connect("references.db")
        self.displayPrevTxfr()

    def displayPrevTxfr(self):
        # Query the database and display the most recent transfer date
        self.result = self.db.execute('SELECT time FROM previousTxfr ORDER BY time DESC LIMIT 1')
            # This query yields the most recent timestamp from the database...
        self.prevTime = self.result.fetchone()
        if self.prevTime != None:
            self.lastCheck = datetime.datetime.fromtimestamp(self.prevTime[0])
            self._previous.set(self.lastCheck.strftime("%a, %d %b %Y %I:%M%p"))
        else:  # Database is empty...No previous times recorded
            self.lastCheck = datetime.datetime.now() - datetime.timedelta(days = 1)
            self._previous.set("Unavailable")
        # Reset the cursor for the query result...???
        self.result = ""  # I'm sure there's a better way to do this...=)

    def chooseSrcDir(self):
        # Display a Directory Selection Dialog and display user's selection for Source Directory
        self._source.set(filedialog.askdirectory(title = "Choose a Source directory...",
                                                initialdir = "C:\\Users\\student\\Desktop"))
        if self._source.get() != "" and self._destination.get() != "":
            if self.transferButton.instate(["disabled"]):
                self.transferButton.state(["!disabled"])

    def chooseDestDir(self):
        #Display a Directory Selection Dialog and display user's selection for Destination Directory
        self._destination.set(filedialog.askdirectory(title = "Choose a Destination directory...",
                                                     initialdir = "C:\\Users\\student\\Desktop"))
        if self._source.get() != "" and self._destination.get() != "":
            if self.transferButton.instate(["disabled"]):
                self.transferButton.state(["!disabled"])

    def transferScript(self):
        # Transfer the new and recently modified files in the Source Directory to the Destination Directory
        self.now = datetime.datetime.now()
        self.messages = []
        self.txfrCount = 0
        for f in os.listdir(self._source.get()):
            if datetime.datetime.fromtimestamp(os.stat(self._source.get() + "/" + f).st_mtime) >= self.lastCheck:
                shutil.move(self._source.get() + "/" + f, self._destination.get())
                self.messages.append("File moved: " + self._source.get() + "/" + f + "\n")
                self._feedback.set("".join(self.messages))
                self.txfrCount += 1
        if self.txfrCount == 0:
            self._feedback.set("No recent updates; no new files\n0 Files Transfered")
        elif self.txfrCount == 1:
            self.messages.append("1 File Transfered")
            self._feedback.set("".join(self.messages))
        else:
            self.messages.append("{} Files Transfered".format(self.txfrCount))
            self._feedback.set("".join(self.messages))
        # Record the time of this execution to the database for reference.
        self.nowTuple = self.now.timetuple()
        self.nowFloat = time.mktime(self.nowTuple)
        self.db.execute('''INSERT INTO previousTxfr (time, source, destination, numfiles)
                            VALUES (?, ?, ?, ?)''',
                            (self.nowFloat, self._source.get(), self._destination.get(), self.txfrCount))
        self.db.commit()
        self.displayPrevTxfr()

def main():

    root = Tk()
    root.title("Daily Transfer")
    root.geometry("600x300+150+150")
    app = userUtil(root)
    root.mainloop()

if __name__ == "__main__": main()