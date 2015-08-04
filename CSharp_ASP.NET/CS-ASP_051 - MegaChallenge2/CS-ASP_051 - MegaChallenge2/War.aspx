<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="War.aspx.cs" Inherits="CS_ASP_051___MegaChallenge2.War" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <h2>Let's Play War!</h2>
    <form id="form1" runat="server">
    <div>
        Enter Player1&#39;s Name:&nbsp;
        <asp:TextBox ID="player1NameTextBox" runat="server">Player1</asp:TextBox>
        <br />
        Enter Player2&#39;s Name:&nbsp;
        <asp:TextBox ID="player2NameTextBox" runat="server">Player2</asp:TextBox>
        <br />
        <br />
        <asp:Button ID="playButton" runat="server" OnClick="playButton_Click" Text="Play War!" />
        <br />
        <br />
        <asp:Label ID="resultLabel" runat="server"></asp:Label>
    
    </div>
    </form>
</body>
</html>
