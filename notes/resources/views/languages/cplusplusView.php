<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?php echo $title; ?></h1>
      </div>
      <p class="lead"></p>
      
<pre class="prettyprint lang-cpp">
#include &lt;iostream>
using namespace std;

int main()
{
    int int1, int2, int3;
    
    cout&lt;&lt;"\t\t\t    Highest Number"&lt;&lt;endl
        &lt;&lt;"\t\t\t    --------------"&lt;&lt;endl&lt;&lt;endl;
    cout&lt;&lt;"This program will display the highest integer entered by the user."
        &lt;&lt;endl&lt;&lt;endl&lt;&lt;endl;
        
    cout&lt;&lt;"Please input 1st integer = ";
    cin>>int1;
    cout&lt;&lt;"Please input 2nd integer = ";
    cin>>int2;
    cout&lt;&lt;"Please input 3rd integer = ";
    cin>>int3;
    cout&lt;&lt;"\n\nThe highest number is ";
    
    if(int1>int2 &amp;&amp; int1>int3)
    {
        cout&lt;&lt;int1;
    }//end if
    else if(int2>int3 &amp;&amp; int2>int2)
    {
        cout&lt;&lt;int2;
    }//end else-if
    else
    {
        cout&lt;&lt;int3;
    }//end else
    cout&lt;&lt;"."&lt;&lt;endl&lt;&lt;endl;
    return 0;
}//end main
</pre>
    </div>

<?php require_once(assets("includes/footer.php")); ?>