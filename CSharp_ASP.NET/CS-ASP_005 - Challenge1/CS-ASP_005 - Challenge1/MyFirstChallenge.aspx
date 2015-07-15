<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="MyFirstChallenge.aspx.cs" Inherits="CS_ASP_005___Challenge1.MyFirstChallenge" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form id="form1" runat="server">
    <div>
    
        How old are you?&nbsp;
        <asp:TextBox ID="userAgeTextBox" runat="server"></asp:TextBox>
        <br />
        <br />
        How much money do you have in your pocket?&nbsp;
        <asp:TextBox ID="userMoneyTextBox" runat="server"></asp:TextBox>
        <br />
        <br />
        <asp:Button ID="fortuneButton" runat="server" OnClick="fortuneButton_Click" Text="Click Me To See Your Fortune" />
        <br />
        <br />
        <asp:Label runat="server" ID="labelTextBox"></asp:Label>
    
    </div>
    </form>
</body>
</html>
