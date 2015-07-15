<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Casino.aspx.cs" Inherits="CS_ASP_034___MegaChallenge1.Casino" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form id="form1" runat="server">
    <div>
    
        <asp:Image ID="Image1" runat="server" Height="160px" Width="123px" />
&nbsp;
        <asp:Image ID="Image2" runat="server" Height="160px" Width="123px" />
&nbsp;
        <asp:Image ID="Image3" runat="server" Height="160px" Width="123px" />
        <br />
        <br />
        Your Bet:&nbsp; <asp:TextBox ID="playerBetTextBox" runat="server"></asp:TextBox>
        <br />
        <br />
        <asp:Button ID="pullButton" runat="server" OnClick="pullButton_Click" Text="Pull The Lever!" />
&nbsp;&nbsp;&nbsp;&nbsp;
        <asp:Label ID="betFeedback" runat="server" Font-Italic="True" ForeColor="Red"></asp:Label>
        <br />
        <br />
        <asp:Label ID="resultLabel" runat="server"></asp:Label>
        <br />
        <br />
        <asp:Label ID="moneyLabel" runat="server"></asp:Label>
        <br />
        <br />
        1 Cherry - x2 Your Bet<br />
        2 Cherries - x3 Your Bet<br />
        3 Cherries - x4 Your Bet<br />
        3 7&#39;s - Jackpot! - x100 Your Bet<br />
        HOWEVER ... If there&#39;s even one BAR, you win nothing.</div>
    </form>
</body>
</html>
