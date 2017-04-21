<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 21/03/2017
 * Time: 17:12
 */

include("header.php");
include_once("includes/function.inc.php");

validateUser();


 if(isset($_POST["Submit"])=="Submit")

{

		extract($_POST);

$result="select * from category where CategoryName='$CategoryName'";

$query=mysql_query($result) or die(mysql_error());

$numRow=mysql_num_rows($query);

if($numRow>0)

{

 $_SESSION["msg"]="Category Already Exists";

   header("Location:".$_SERVER['PHP_SELF']);

   exit;

 }

		$cQuery="insert into category set    

						    CategoryName             = '".($CategoryName)."',

							details					='".$_POST["details"]."'

												 						 

						 ";



			 $image=$_FILES["image"]["name"];

			 if($image!="")

			 {

			    $cQuery.=",Image ='".$image."'"    ;

	            $target="CatImage/";

				$source=$_FILES["image"]["tmp_name"];

				$target=$target.$image;

				move_uploaded_file($source,$target) ;

	          }



		$RowCons=mysql_query($cQuery) or die(mysql_error());

		if($RowCons)

		   {

				 $_SESSION["msg"]="One Record Is Inserted ";

				 header("location:CategoryList.php");

				 exit() ;



		   }







}





?>
<div id="content_main" class="clearfix"><div id="main_panel_container" class="left" >
<div id="dashboard">
      <h2 class="ico_mug">Add Group Category</h2>

      <form id="form2" name="form2" method="post" action="" enctype="multipart/form-data">

        <table width="92%" border="0" align="center" cellpadding="10" cellspacing="0">

		 <tr>

                <td height="30" colspan="7" align="center" class="externalcss"><?php

		                               if(isset($_SESSION["msg"]))

										{

										echo $_SESSION["msg"];

										unset($_SESSION["msg"]);

										}

								?></td>
              </tr>


          <tr>

            <td width="18%" align="right">Category Name :</td>

            <td width="56%">

              <input name="CategoryName" type="text" class="txtbox-grey2" id="Name"/>  </td>
<td width="26%">&nbsp;  </td>
          </tr>


			   <tr>

                <td height="90" align="right" valign="middle">Details</td>

                <td colspan="2" align="left">

           <?php

				// Include CKEditor class.

				include_once "ckeditor/ckeditor.php";

				$CKEditor = new CKEditor("details");

				// The initial value to be displayed in the editor.



				 //$CKEditor->Value =$CatRowresult["why"];



				$CKEditor->config['width'] = 550;

				// Change default textarea attributes



				$CKEditor->textareaAttributes = array("cols" => 80, "rows" =>10);

				// Create class instance.



				// Path to CKEditor directory, ideally instead of relative dir, use an absolute path:

				//   $CKEditor->basePath = '/ckeditor/'

				// If not set, CKEditor will try to detect the correct path.



				$CKEditor->basePath = 'ckeditor/';

				// Create textarea element and attach CKEditor to it.

				$CKEditor->editor("details");

			?>				</td>
              </tr>



          <tr>

            <td align="right">&nbsp;</td>



            <td><input name="Submit" type="submit" class="button-bg"  style="width:150px;" value="Submit"/> </td>
            <td>&nbsp;  </td>
          </tr>

          <tr>

            <td align="right">&nbsp;</td>

            <td>&nbsp;</td>
              <td>&nbsp;  </td>
          </tr>
        </table>

            </form>
 </div>
      </div>

 </div>
<?php include("footer.php");?>