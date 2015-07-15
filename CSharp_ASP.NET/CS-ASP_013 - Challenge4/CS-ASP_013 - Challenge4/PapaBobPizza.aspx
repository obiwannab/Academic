<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="PapaBobPizza.aspx.cs" Inherits="CS_ASP_013___Challenge4.PapaBobPizza" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <style type="text/css">
        .auto-style1 {
            color: #FF0000;
        }
        .auto-style2 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: x-large;
        }
    </style>
</head>
<body>
    <form id="form1" runat="server">
    <div>
    
        <asp:Image ID="Image1" runat="server" ImageUrl="~/PapaBob.png" />
        <span class="auto-style2"><strong>Papa Bob&#39;s Pizza and Software</strong></span></div>
        <p>
            <asp:RadioButton ID="babySizeRadio" runat="server" GroupName="sizeGroup" Text="Baby Bob Size (10&quot;) - $10" />
            <br />
            <asp:RadioButton ID="mamaSizeRadio" runat="server" GroupName="sizeGroup" Text="Mama Bob Size (13&quot;) - $13" />
            <br />
            <asp:RadioButton ID="papaSizeRadio" runat="server" GroupName="sizeGroup" Text="Papa Bob Size (16&quot;) - $16" />
        </p>
        <p>
            <asp:RadioButton ID="thinCrustRadio" runat="server" GroupName="crustGroup" Text="Thin Crust" />
            <br />
            <asp:RadioButton ID="deepCrustRadio" runat="server" GroupName="crustGroup" Text="Deep Dish (+$2.00)" />
        </p>
        <p>
            <asp:CheckBox ID="pepperoniBox" runat="server" Text="Pepperoni (+$1.50)" />
            <br />
            <asp:CheckBox ID="onionsBox" runat="server" Text="Onions (+$0.75)" />
            <br />
            <asp:CheckBox ID="greenPeppersBox" runat="server" Text="Green Peppers (+$0.50)" />
            <br />
            <asp:CheckBox ID="redPeppersBox" runat="server" Text="Red Peppers (+$0.75)" />
            <br />
            <asp:CheckBox ID="anchoviesBox" runat="server" Text="Anchovies (+$2.00)" />
        </p>
        <h3 style="font-family: Arial, Helvetica, sans-serif">Papa Bob&#39;s <span class="auto-style1">Special Deal</span></h3>
        <h4>Save $2.00 when you add Pepperoni, Green Peppers, and Anchovies OR Pepperoni, Red Peppers, and Onions to your pizza.</h4>
        <p>
            <asp:Button ID="purchaseButton" runat="server" OnClick="purchaseButton_Click" Text="Purchase" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total:&nbsp;
            <asp:Label ID="totalLabel" runat="server" Text="$0.00"></asp:Label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <asp:Label ID="messageLabel" runat="server" Font-Bold="True" Font-Italic="True" ForeColor="Red"></asp:Label>
        </p>
        <p>
            Sorry, at this time you can only order one pizza online, and pick-up only...we need a better website!</p>
    </form>
</body>
</html>
