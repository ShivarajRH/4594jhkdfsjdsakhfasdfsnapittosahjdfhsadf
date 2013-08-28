<?php $p=false; if(isset($prod)) $p=$prod;?>
<div class="container">
<h2><?=$p?"Edit":"Add new"?> product</h2>

 <?php 
//if(isset($errors)):
// 		foreach($errors as $error):
// 			echo "<br>".$error." is empty";
// 		endforeach;
// 	endif;

echo validation_errors('<span class="error_strings">','</span><br>'); 

?>


<form name="addproductform" id="addproductform" method="post">
    
    <div id='addproductform_errorloc' class='error_strings'></div>
    
<table>
<tr><td>Product Name <span class="required">*</span>:</td><td><input type="text" name="pname" size=30 value="<?=$p?$p['product_name']:set_value('pname');?>">
        <div id="addproductform_pname_errorloc"></div></td></tr>
<tr><td>Short Description <span class="required">*</span>:</td><td><input type="text" name="pdesc" size=50 value="<?=$p?$p['short_desc']:""?>">
    <div id="addproductform_pdesc_errorloc"></div></td></tr>
<tr><td>Size <span class="required">*</span>:</td><td><input type="text" name="psize" size=5 value="<?=$p?$p['size']:""?>">
    <div id="addproductform_psize_errorloc"></div></td></tr>
<tr><td>Unit of measurement <span class="required">*</span>:</td><td><input type="text" name="puom" value="<?=$p?$p['uom']:""?>">
    <div id="addproductform_puom_errorloc"></div></td></tr>
<tr><td>MRP <span class="required">*</span>:</td><td><input type="text" name="pmrp" size=4 value="<?=$p?$p['mrp']:""?>">
    <div id="addproductform_pmrp_errorloc"></div></td></tr>
<tr><td>VAT <span class="required">*</span>:</td><td><input type="text" name="pvat" size=2 value="<?=$p?$p['vat']:""?>">%
    <div id="addproductform_pvat_errorloc"></div></td></tr>
<tr><td>Purchase Cost <span class="required">*</span>:</td><td><input type="text" name="pcost" value="<?=$p?$p['purchase_cost']:""?>">
    <div id="addproductform_pcost_errorloc"></div></td></tr>
<tr><td>Barcode <span class="required">*</span>:</td><td><input type="text" name="pbarcode" value="<?=$p?$p['barcode']:""?>">
    <div id="addproductform_pbarcode_errorloc"></div></td></tr>
<tr><td>Is Offer :</td><td><input type="checkbox" name="pisoffer" value=1 <?=$p?($p['is_offer']?"checked":""):""?>></td></tr>
<tr><td>Is Sourceable :</td><td><input type="checkbox" name="pissrc" value="1" <?=$p?($p['is_sourceable']?"checked":""):""?>></td></tr>
<tr><td>Is Serial No.required :</td><td><input type="checkbox" name="pissno" value="1" <?=$p?($p['is_serial_required']?"checked":""):""?>></td></tr>
<tr><td>Brand :</td><td>
<select name="pbrand">
<?php foreach($this->db->query("select id,name from king_brands order  by name asc")->result_array() as $b){?>
<option value="<?=$b['id']?>" <?=$p?($p['brand_id']==$b['id']?"selected":""):""?>><?=$b['name']?></option>
<?php }?>
</select>
</td></tr>
<tr style="display:none;"><td>Rackbin :</td><td>
<select name="prackbin">
<?php foreach($this->db->query("select * from m_rack_bin_info order by rack_name asc")->result_array() as $b){?>
<option value="<?=$b['id']?>"><?=$b['rack_name']?><?=$b['bin_name']?></option>
<?php }?>
</select>
</td></tr>
<tr><td>MOQ <span class="required">*</span>:</td><td><input type="text" name="pmoq" value="<?=$p?$p['moq']:""?>">
    <div id="addproductform_pmoq_errorloc"></div></td></tr>
<tr><td>Reorder Level <span class="required">*</span>:</td><td><input type="text" name="prorder" value="<?=$p?$p['reorder_level']:""?>">
    <div id="addproductform_prorder_errorloc"></div></td></tr>
<tr><td>Reorder Qty <span class="required">*</span>:</td><td><input type="text" name="prqty" value="<?=$p?$p['reorder_qty']:""?>">
    <div id="addproductform_prqty_errorloc"></div></td></tr>
<tr><td>Remarks <span class="required">*</span>:</td><td><input type="text" name="premarks" value="<?=$p?$p['remarks']:""?>">
    <div id="addproductform_premarks_errorloc"></div></td></tr>
<tr><td>Is Active :</td><td><input type="checkbox" name="is_active" value="1" <?=$p&&$p['is_active']?"checked":""?>></td></tr>
<!--
<tr><td>News Letter :</td><td>
        <br><input type="checkbox" name="letters" value="daily">Daily<br>
        <input type="checkbox" name="letters" value="monthly">monthly<br>
    </td></tr>
<tr><td>Gender :</td><td>
        <input type="radio" name="gender" value="male">male<br>
        <input type="radio" name="gender" value="female">female<br>
    </td></tr>
<tr><td>Gender :</td><td>
        <br>
        <select name="genderx">
            <option value="00">Select</option>
            <option value="male">male</option>
            <option value="female">female</option>
        </select>
        <br>
    </td></tr>
<tr><td>PWD :</td><td><input type="password" name="pwd" value=""><br>
        Confirm PWD :</td><td><input type="password" name="cpwd" value=""><br>
    </td></tr>-->

<tr><td></td><td><input type="submit" value="<?=$p?"Update":"Add"?> product">
</table>
</form>

<script type="text/javascript">
   
        var formname='addproductform';
        var frmvalidator  = new Validator(formname);
	frmvalidator.clearAllValidations();
	frmvalidator.EnableFocusOnError(false);
        //=====FOR DISPLAY WHOLE WITHOUT POPUP
            frmvalidator.EnableOnPageErrorDisplaySingleBox();
        //===FOR DISPLAY INDIVIDUALY BELOW INPUTBOX
            //frmvalidator.EnableOnPageErrorDisplay();
        
	frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("pname","req","Please enter Product Name.");
	frmvalidator.addValidation("pname","maxlen=40",
	                                          "Max length for Product Name is 40");

	
	frmvalidator.addValidation("pdesc","req","Please enter Product Description.");
	frmvalidator.addValidation("psize","req","Please enter Product Size.");
	frmvalidator.addValidation("puom","req","Please enter Unit of Measurement.");
	frmvalidator.addValidation("pmrp","req","Please enter MRP");
	frmvalidator.addValidation("pvat","req","Please enter Product VAT");
	frmvalidator.addValidation("pcost","req","Please enter Product Cost");
	frmvalidator.addValidation("pbarcode","req","Please enter Barcode");
	//frmvalidator.addValidation("pisoffer","req","Please select Is Offer");//frmvalidator.addValidation("pissrc","req","Please select Is Sourceable");//frmvalidator.addValidation("pissno","req","Please select Is Serial No.required");//frmvalidator.addValidation("pbrand","req","Please select Brand");//frmvalidator.addValidation("prackbin","req","Please enter Product Name");
	frmvalidator.addValidation("pmoq","req","Please enter MOQ.");
	frmvalidator.addValidation("prorder","req","Please enter Reorder Level");
	frmvalidator.addValidation("prqty","req","Please enter Reorder Qty");
	frmvalidator.addValidation("premarks","req","Please enter Product Remarks.");
	//frmvalidator.addValidation("is_active","req","Please check Is Active");
        
	/*
        frmvalidator.addValidation("letters","shouldselchk=daily","Please select news letters");
        frmvalidator.addValidation("gender","selone","Please select gender");
        frmvalidator.addValidation("genderx","dontselect=00","Please select genderx");
        frmvalidator.addValidation("pwd","req","Please enter pwd.");
        frmvalidator.addValidation("pwd","neelmnt=pname","Password should not same as product name.");
        frmvalidator.addValidation("cpwd","eqelmnt=pwd","Confirm password is not same as pwd.");
        */
        
</script>
<script type="text/javascript">
    function afterValidation() {
        // Trigger the validations
        var d= document.addproductform.runvalidation();
        if(d) {
            var val=confirm("Are u sure you want to submit the form?");
            if(val) {   $("#addproductform_errorloc").html("<p>Form is submitting......</p>"); return true;     }
            else {    return false;      }
        }
        else {
            //"Errors"
            return false;
        }

    }
    function beforeValidation() {
        var val=confirm("Are u sure you want to submit the form?");
        if(val) {
            // Trigger the validations
            return document.addproductform.runvalidation();
        }
        else {
            return false;
        }
    }
       
    document.addproductform.runvalidation = document.addproductform.onsubmit;
    document.addproductform.onsubmit = afterValidation;
</script>

</div>

<?php
