Project Description

==================
BANK PSEUDOCODE
==================

global $var Username
global $var Name
global $var Balance
global $var History

Main(){
   while (true){
      In HTML have a login screen for username & password and option to create account.
      LoadAccount();
      LoggedOnUI();
   }
}

LoggedOnUI(){
   Show Page for Logged In Account:
   + CheckBalance
   + CheckHistory
   + Deposit
   + Withdraw
   + Logout
   + DeleteAccount
}

LoadAccount(){
   get Form Information from WebPage;

   if (!Account/File Exists){
      echo "Account Does Not Exist for Username."
        If (Prompt For Account Creation == True)
         AddAccount();
      Else
         Return to Login;
   }
   else if(Valid Username && Password)
      Load Information from File;
}

AddAccount(){
   Prompt for User Info;
   Create File for Username;
   Write Username, Password, Name, InitialDeposit to File;
}

DeleteAccount(){
   Delete File;
   Logout();
   echo "Account Deleted";
}

CheckBalance(){
   echo Balance;
}

CheckHistory(){
   if(History != Empty)
      echo "No History Found."
   else
      for(History Length)
         echo History[index];
}

Deposit(Amount){
   Balance += Amount;
   Add to History Variable;
   Write Line to History on File;
   echo "Deposited $Amount.";
}

Withdraw(Amount){
   if(Balance >= Amount){
      Balance -= $Amount;
      Add to History Variable;
      Write Line to History on File;
      echo "Withdrawn $Amount.";
   } else
      echo "Insufficient Funds.";
}

Logout(){
   Unload Info;
   Return to Login;
}