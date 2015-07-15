<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="EpicSpiesAssetTracker.aspx.cs" Inherits="CS_ASP_023___Challenge7.EpicSpiesAssetTracker" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <style type="text/css">
        .auto-style1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: x-large;
        }
    </style>
</head>
<body>
    <form id="form1" runat="server">
    <div>
    
        <asp:Image ID="Image1" runat="server" Height="187px" ImageUrl="~/epic-spies-logo.jpg" />
        <br />
        <span class="auto-style1"><strong>Asset Performance Tracker</strong></span><br />
        <br />
        Asset Name:&nbsp;
        <asp:TextBox ID="nameTextBox" runat="server"></asp:TextBox>
&nbsp;&nbsp;&nbsp;&nbsp;
        <asp:Label ID="nameFeedback" runat="server" Font-Bold="True" Font-Italic="True" ForeColor="Red"></asp:Label>
        <br />
        <br />
        Elections Rigged:&nbsp; <asp:TextBox ID="electRiggTextBox" runat="server"></asp:TextBox>
&nbsp;&nbsp;&nbsp;&nbsp;
        <asp:Label ID="electRiggFeedback" runat="server" Font-Bold="True" Font-Italic="True" ForeColor="#0000CC"></asp:Label>
        <br />
        <br />
        Acts of Subterfuge Performed:&nbsp; <asp:TextBox ID="actsSubterTextBox" runat="server"></asp:TextBox>
&nbsp;&nbsp;&nbsp;&nbsp;
        <asp:Label ID="actsSubterFeedback" runat="server" Font-Bold="True" Font-Italic="True" ForeColor="#660066"></asp:Label>
        <br />
        <br />
        <asp:Button ID="addAssetButton" runat="server" OnClick="addAssetButton_Click" Text="Add Asset" />
        <br />
        <br />
        <asp:Label ID="resultLabel" runat="server"></asp:Label>
    
    </div>
    </form>
</body>
</html>
