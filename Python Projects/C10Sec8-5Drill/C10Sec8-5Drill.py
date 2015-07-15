#!/user/bin/env
# Python Course
# Section 8 - Item #5
#   DRILL: db - Python 2.7
#   Desired features--
#     Need to create a database to record the last time the file check/transfer took place
#     Need to display the last date and time the flie check/transfer was perform to the GUI
#     Need to use the last date and time as the reference point for checking for new or modified files
#
import os, shutil, datetime, time, wx, sqlite3

class userUtil(wx.Frame):
    def __init__(self, parent, title):
        super(userUtil, self).__init__(parent, title = title, pos = (150, 150), size = (600, 300))
        self.panel = wx.Panel(self)
        
        # Create Buttons for user to select directories and execute the transfer
        self.srcButton = wx.Button(self.panel, label = "Source Directory",
                                            pos = (5, 5), size = (150, 25))
        self.srcButton.Bind(wx.EVT_BUTTON, self.chooseSrcDir)
        self.destButton = wx.Button(self.panel, label = "Destination Directory",
                                            pos = (5, 40), size = (150, 25))
        self.destButton.Bind(wx.EVT_BUTTON, self.chooseDestDir)
        self.txfrButton = wx.Button(self.panel, label = "Transfer Files",
                                            pos = (5, 75), size = (150, 25))
        self.txfrButton.Bind(wx.EVT_BUTTON, self.transferScript)

        # Initialize Directory variables
        self.source = None
        self.destination = None

        # Create StaticText areas to display user's selection from dialogues and last transfer info
        wx.StaticText(self.panel, pos = (5, 110), size = (150, 25), label = "Last Check/Transfer On:")
        self.lastTxt = wx.StaticText(self.panel, pos = (5, 135), size = (150, 25))
        self.srcTxt = wx.StaticText(self.panel, pos = (160, 10))
        self.destTxt = wx.StaticText(self.panel, pos = (160, 45))
        self.txfrTxt = wx.StaticText(self.panel, pos = (160, 80))

        # Connect to reference database and display last transfer date
        self.db = sqlite3.connect("references.db")
        self.displayPrevTxfr()

    def displayPrevTxfr(self):
        # Query the database and display the most recent transfer date
        self.result = self.db.execute('SELECT time FROM previousTxfr ORDER BY time DESC LIMIT 1')
            # This query yeilds the most recent timestamp from the database...
        self.previousTime = self.result.fetchone()
        if self.previousTime != None:
            self.lastCheck = datetime.datetime.fromtimestamp(self.previousTime[0])
            self.lastTxt.SetLabel(self.lastCheck.strftime("%a, %d %b %Y %I:%M%p"))
        else:  # Database is empty...No previous times recorded
            self.lastCheck = datetime.datetime.now() - datetime.timedelta(days = 1)
            self.lastTxt.SetLabel("Unavailable")
        # Reset the cursor for the query result...???
        self.result = ""  # I'm sure there's a better way to do this...=)

    def chooseSrcDir(self, e):
        # Display a Directory Selection Dialog and display user's selection for Source Directory
        self.dialog = wx.DirDialog(self, message = "Choose a Source directory...",
                                    defaultPath = "C:\\Users\\student\\Desktop")
        if self.dialog.ShowModal() == wx.ID_OK:
            self.source = self.dialog.GetPath()
            self.srcTxt.SetLabel(self.source)

    def chooseDestDir(self, e):
        # Display a Directory Selection Dialog and display user's selection for Destination Directory
        self.dialog = wx.DirDialog(self, message = "Choose a Destination directory...",
                                    defaultPath = "C:\\Users\\student\\Desktop")
        if self.dialog.ShowModal() == wx.ID_OK:
            self.destination = self.dialog.GetPath()
            self.destTxt.SetLabel(self.destination)

    def transferScript(self, e):
        # Transfer the new and recently modified files in the Source Directory to the Destination Directory
        # First, verify that directories have been selected
        if self.source == None and self.destination == None:
            self.txfrTxt.SetLabel("Please select a Source Directory\n  and a Destination Directory")
            return
        elif self.source == None:
            self.txfrTxt.SetLabel("Please select a Source Directory.")
            return
        elif self.destination == None:
            self.txfrTxt.SetLabel("Please select a Destination Directory.")
            return
        # Next, Loop through all the files in the source directory and perform the transfer
        self.now = datetime.datetime.now()
        self.checkTime = self.lastCheck
        self.messages = []
        self.txfrCount = 0
        for f in os.listdir(self.source):
            if datetime.datetime.fromtimestamp(os.stat(self.source + "\\" + f).st_mtime) >= self.checkTime:
                shutil.move(self.source + "\\" + f, self.destination)
                self.messages.append("File moved: " + self.source + "\\" + f + "\n")
                self.userFdbk = "".join(self.messages)
                self.txfrTxt.SetLabel(self.userFdbk)
                self.txfrCount += 1
        if self.txfrCount == 0:
            self.txfrTxt.SetLabel("No recent updates; no new files\n0 Files Transfered")
        elif self.txfrCount == 1:
            self.messages.append("1 File Transfered")
            self.userFdbk = "".join(self.messages)
            self.txfrTxt.SetLabel(self.userFdbk)
        else:
            self.messages.append("%r Files Transfered" % self.txfrCount)
            self.userFdbk = "".join(self.messages)
            self.txfrTxt.SetLabel(self.userFdbk)
        # Record the time of this execution to the database for reference.
        self.nowTuple = self.now.timetuple()
        self.nowFloat = time.mktime(self.nowTuple)
        #self.db.execute('INSERT INTO previousTxfr (time) VALUES (?)', (self.nowFloat,))  # This was used during initial development
        self.db.execute('''INSERT INTO previousTxfr (time, source, destination, numfiles)
                            VALUES (?, ?, ?, ?)''',
                            (self.nowFloat, self.source, self.destination, self.txfrCount))
        self.db.commit()
        self.displayPrevTxfr()

def main():

    app = wx.App()
    frame = userUtil(None, title = "Daily Transfer")
    frame.Show()
    app.MainLoop()

if __name__ == "__main__": main()
