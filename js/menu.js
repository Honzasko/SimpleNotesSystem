function ChangeTheme()
{
    const theme = document.cookie
    .split('; ')
    .find((row) => row.startsWith('theme_notess'))
    ?.split('=')[1];

    if(theme == "dark")
    {
        document.cookie = "theme_notess=light";
    }
    else {
        document.cookie = "theme_notess=dark";
    }
   document.location.reload()
}