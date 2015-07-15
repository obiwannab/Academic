<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="PostalCalculatorMethods.aspx.cs" Inherits="CS_ASP_034___Challenge9.PostalCalculatorMethods" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form id="form1" runat="server">
    <div>
    
        Postal Calculator<br />
        <br />
        Length:&nbsp;
        <asp:TextBox ID="lengthTextBox" runat="server" AutoPostBack="True"></asp:TextBox>
&nbsp;
        <asp:Label ID="lengthFeedback" runat="server" Font-Italic="True" ForeColor="Red" Text="Required" Visible="False"></asp:Label>
        <br />
        Width:&nbsp;
        <asp:TextBox ID="widthTextBox" runat="server" AutoPostBack="True"></asp:TextBox>
&nbsp;
        <asp:Label ID="widthFeedback" runat="server" Font-Italic="True" ForeColor="Red" Text="Required" Visible="False"></asp:Label>
        <br />
        Height:&nbsp;
        <asp:TextBox ID="heightTextBox" runat="server" AutoPostBack="True"></asp:TextBox>
        <br />
        <br />
        <asp:RadioButton ID="groundRadioButton" runat="server" AutoPostBack="True" GroupName="ShippingGroup" Text="Ground" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <asp:Label ID="shippingFeedback" runat="server" Font-Bold="True" Font-Italic="False" ForeColor="Blue" Text="Please choose a shipping method"></asp:Label>
        <br />
        <asp:RadioButton ID="airRadioButton" runat="server" AutoPostBack="True" GroupName="ShippingGroup" Text="Air" />
        <br />
        <asp:RadioButton ID="nextDayRadioButton" runat="server" AutoPostBack="True" GroupName="ShippingGroup" Text="Next Day" />
        <br />
        <br />
        <asp:Label ID="resultLabel" runat="server"></asp:Label>
    
    </div>
    </form>
</body>
</html>
