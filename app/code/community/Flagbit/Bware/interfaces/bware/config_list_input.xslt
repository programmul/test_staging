<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns="http://mip.flagbit.com/magento-data"  version="1.0">


	<xsl:template match="/">
		<data array="true">
			<xsl:apply-templates select="/BWProducts/Product"/>
	</data>
	</xsl:template>
	
	<xsl:template match="Product">	
		<product>
			<xsl:apply-templates select="*"/>
		</product>
	</xsl:template>
    
    <xsl:template match="DATA_set">
		<set><xsl:value-of select="."/></set>
    </xsl:template>
    
        
    <xsl:template match="DATA_type">
        <type><xsl:value-of select="."/></type>
    </xsl:template>


	<xsl:template match="DATA_sku">
		<sku><xsl:value-of select="."/></sku>
        <mip_datahash_id><xsl:value-of select="."/></mip_datahash_id>	
    </xsl:template>
    
   
    <xsl:template match="DATA_weight">
		<weight><xsl:value-of select="."/></weight>
    </xsl:template>
    
    <xsl:template match="DATA_category_ids">
		<category_ids><xsl:value-of select="."/></category_ids>
    </xsl:template>
    
     <xsl:template match="DATA_status">
		<status><xsl:value-of select="."/></status>
    </xsl:template>
    
     <xsl:template match="DATA_visibility">
		<visibility><xsl:value-of select="."/></visibility>
    </xsl:template>
    
    <xsl:template match="DATA_name">
		<name><xsl:value-of select="."/></name>
    </xsl:template>
    
     <xsl:template match="DATA_description">
		<description><xsl:value-of select="."/></description>
    </xsl:template>
    
        <!--<xsl:template match="DATA_images">
        <images array="true">
            <xsl:call-template name="parseImages">
                <xsl:with-param name="str" select="."/>
                <xsl:with-param name="splitString" select="','"/>
            </xsl:call-template>
        </images>
    </xsl:template>-->
    
    
    <xsl:template match="DATA_short_description">
		<short_description><xsl:value-of select="."/></short_description>
    </xsl:template>
    
    <xsl:template match="DATA_price">
		<price><xsl:value-of select="."/></price>
    </xsl:template>
    
    <xsl:template match="DATA_tax_class_id">
		<tax_class_id><xsl:value-of select="."/></tax_class_id>
    </xsl:template>
    
		

    

    
    <xsl:template match="NODE_Filter">
		<kinder_groese><xsl:value-of select="mip:attributeOptionValue('kinder_groese', string(./NODE_Filter/DATA_groese), null, 0, null, true)"/></kinder_groese>
        <kinder_toene><xsl:value-of select="mip:attributeOptionValue('kinder_toene', string(./NODE_Filter/DATA_toene), null, 0, null, true)"/></kinder_toene>
        <kinder_weite><xsl:value-of select="mip:attributeOptionValue('kinder_weite', string(./NODE_Filter/DATA_weite), null, 0, null, true)"/></kinder_weite>    
    
    <stock_data>
    <use_config_min_sale_qty>1</use_config_min_sale_qty>
    <use_config_max_sale_qty>1</use_config_max_sale_qty>
     <qty><xsl:value-of select="../DATA_qty"/></qty>
    <is_in_stock>1</is_in_stock>
    </stock_data>
    
    <website_ids array="true">
    	<website_id><xsl:value-of select="../DATA_website"/></website_id>
    </website_ids>
    
    <store_ids array="true">
    	<store_id><xsl:value-of select="../DATA_store"/></store_id>
    </store_ids>
    
    

            
    <xsl:if test="../DATA_type = 'configurable'">
    <!--<configurable_attributes_data array="true">
            <node>
                <label><xsl:value-of select="../DATA_label"/></label>
                <position>1</position>
                <id><xsl:value-of select="../DATA_sku"/>-Filter</id>
                <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code1))"/></attribute_id>
                <attribute_code>futter_config</attribute_code>
                <values array="true">
                    <value>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config1), null, 0, null, true)"/></value_index>
                        <is_percent>0</is_percent>
                        <pricing_value>0</pricing_value>
                    </value>
                </values>
            </node>
        </configurable_attributes_data>-->
		
		<configurable_products_data array="true">
            <node>
                <id><xsl:value-of select="../DATA_skuconfig1"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code1))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config1), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
			  <xsl:if test="../DATA_config2 = '2'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig2"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code2))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config2), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config3 = '3'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig3"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code3))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config3), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config4 = '4'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig4"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code4))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config4), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config5 = '5'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig5"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code5))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config5), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config6 = '6'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig6"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code6))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config6), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config7 = '7'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig7"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code7))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config7), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config8 = '8'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig8"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code8))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config8), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config9 = '9'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig9"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code9))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config9), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            <xsl:if test="../DATA_config10 = '10'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig10"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code10))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config10), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
             <xsl:if test="../DATA_config11 = '11'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig11"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code11))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config11), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config12 = '12'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig12"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code12))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config12), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config13 = '13'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig13"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code13))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config13), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config14 = '14'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig14"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code14))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config14), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config15 = '15'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig15"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code15))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config15), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config16 = '16'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig16"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code16))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config16), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config17 = '17'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig17"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code17))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config17), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config18 = '18'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig18"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code18))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config18), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config19 = '19'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig19"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code19))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config19), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
            <xsl:if test="../DATA_config20 = '20'">
             <node>
                <id><xsl:value-of select="../DATA_skuconfig20"/></id>
                <values array="true">
                    <value>
                        <attribute_id><xsl:value-of select="mip:getid('attribute', 'attribute_code', string(./NODE_Filter/DATA_code20))"/></attribute_id>
                        <value_index><xsl:value-of select="mip:attributeOptionValue('futter_config', string(./NODE_Filter/DATA_config20), null, 0, null, true)"/></value_index>
                    </value>
                </values>
            </node>
            </xsl:if>
            
        </configurable_products_data>
    	</xsl:if>
    
    </xsl:template>
    
    
    
    <!--<xsl:template name="parseImages">
        <xsl:param name="str" select="."/>
        <xsl:param name="splitString" select="' '"/>
        
        <xsl:variable name="filename">
            <xsl:choose>
                <xsl:when test="contains($str, $splitString)">
                    <xsl:value-of select="substring-before($str, $splitString)"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="$str"/>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>
        
        <image>
            <types array="true">
            
                <xsl:choose>
                    <xsl:when test="contains($filename, '.')">
                        <type><xsl:text>thumbnail</xsl:text></type>
                        <type><xsl:text>image</xsl:text></type>
                        <type><xsl:text>small_image</xsl:text></type>                        
                    </xsl:when>
                    <xsl:when test="contains($filename, '_2.')">

                    </xsl:when>                        
                </xsl:choose>                    
            
            </types>
            <label/>
            <position>
                <xsl:choose>
                    <xsl:when test="contains($filename, '.')">
                        <xsl:text>1</xsl:text>
                    </xsl:when>
                    <xsl:when test="contains($filename, '_2.')">
                        <xsl:text>2</xsl:text>
                    </xsl:when>
                    <xsl:when test="contains($filename, '_3.')">
                        <xsl:text>3</xsl:text>
                    </xsl:when>
                    <xsl:when test="contains($filename, '_4.')">
                        <xsl:text>4</xsl:text>
                    </xsl:when>
                    <xsl:when test="contains($filename, '_5.')">
                        <xsl:text>5</xsl:text>
                    </xsl:when>
                    <xsl:when test="contains($filename, '_6.')">
                        <xsl:text>6</xsl:text>
                    </xsl:when>    
                    <xsl:when test="contains($filename, '_7.')">
                        <xsl:text>7</xsl:text>
                    </xsl:when>    
                    <xsl:when test="contains($filename, '_8.')">
                        <xsl:text>8</xsl:text>
                    </xsl:when>                        
                    <xsl:when test="contains($filename, '_9.')">
                        <xsl:text>9</xsl:text>
                    </xsl:when>
                    
                    <xsl:otherwise>
                        <xsl:text></xsl:text>
                    </xsl:otherwise>                    
                </xsl:choose>
            </position>            
            <file>
                <xsl:value-of select="concat('/var/mip/bware/images/product_images/', $filename)"/>
            </file>
            <cache>
                <xsl:value-of select="mip:filetime(concat('/var/mip/bware/images/product_images/', string($filename)))"/>
            </cache>
        </image>
        
        <xsl:if test="contains($str,$splitString)">
            <xsl:call-template name="parseImages">
                <xsl:with-param name="str"
                    select="substring-after($str,$splitString)"/>
                <xsl:with-param name="splitString" select="$splitString"/>
            </xsl:call-template>
        </xsl:if>
    </xsl:template>-->
    
    
    
    <xsl:template match="*"> </xsl:template>
    
    
        
        
  
        
</xsl:stylesheet>