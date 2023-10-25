<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Demonstration of the PrimeUI widgets.
File version: 1.0
Last update: 09/18/2015
-->
<script type="text/javascript">
    znetdk.useStyleSheet('<?php echo ZNETDK_ROOT_URI . \General::getFilledMessage(CFG_ZNETDK_CSS, "check_widgets"); ?>');
</script>
<p id="zdk_check_widgets_teaser"><?php echo LC_WIDGETS_MESSAGE;?></p>
<div id="widgets-main-wrapper">
    <div class="widget-wrapper left">
        <div id="example-datepicker"></div>
    </div>
    <fieldset id="example-fieldset">  
        <legend>Fieldset title</legend>
        <div class="widget-wrapper left">
            <textarea id="example-textarea">Text area value...</textarea>
            <div class="widget-wrapper" style="display:block;">
                <input id="example-inputtext" value="Text..." type="text" />
            </div>
            <div class="widget-wrapper" style="display:block;">
                <button id="example-button" type="button">Button</button>
            </div>
        </div>
        <div class="widget-wrapper left">
            <select class="left" id="example-listbox">  
                <option value="0">Select One</option>  
                <option value="1">Option 1</option>  
                <option value="2">Option 2</option>  
                <option value="3">Option 3</option>  
                <option value="4">Option 4</option>  
                <option value="5">Option 5</option>  
            </select>
        </div>
        <div class="widget-wrapper left">
            <table>  
                <tr>  
                    <td><input type="checkbox" name="chk" id="chk1" value="1"/></td>  
                    <td><label for="chk1">Option 1</label></td>  
                </tr>  
                <tr>  
                    <td><input type="checkbox" name="chk" id="chk3" value="3" disabled="disabled"/></td>  
                    <td><label for="chk3">Option 2</label></td>  
                </tr>
                <tr>  
                    <td><input type="radio" name="rd" id="rd1" value="1"/></td>  
                    <td><label for="rd1">Option A</label></td>  
                </tr>  
                <tr>  
                    <td><input type="radio" name="rd" id="rd2" value="2"/></td>  
                    <td><label for="rd2">Option B</label></td>  
                </tr>  
            </table>
        </div>
    </fieldset>
    <div style="clear:left;"></div>
    <div class="widget-wrapper left">
        <div id="example-picklist">
            <select name="source">  
                <option value="1">Value one</option>  
                <option value="2">Value two</option>  
                <option value="3">Value three</option>  
                <option value="4">Value four</option>  
                <option value="5">Value five</option>  
            </select>  
            <select name="target">  
            </select>  
        </div>
    </div>
    <div id="example-tree" class="widget-wrapper left"></div>
    <div class="widget-wrapper left">
        <div id="example-datatable"></div>
    </div>
    <div id="example-menu" class="widget-wrapper left">
        <ul>
            <li><h3>File</h3></li>  
            <li> <a data-icon="ui-icon-document">New</a></li>  
            <li> <a data-icon="ui-icon-folder-open">Open</a></li>  
            <li><h3>Edit</h3></li>  
            <li> <a data-icon="ui-icon-arrowreturnthick-1-w">Undo</a></li>  
            <li> <a data-icon="ui-icon-arrowreturnthick-1-e">Redo</a></li>  
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#example-datepicker").datepicker();
        $("#example-fieldset").puifieldset();
        $("#example-button").puibutton({icon: 'ui-icon-check'});
        $("#example-inputtext").puiinputtext();
        $("#example-listbox").puilistbox();
        $(".widget-wrapper :checkbox").puicheckbox();
        $(".widget-wrapper :radio").puiradiobutton();
        $("#example-textarea").puiinputtextarea();
        $("#example-picklist").puipicklist();
        $("#example-datatable").puidatatable({
            caption: 'Datatable',
            paginator: {
                rows: 4
            },
            columns: [
                {field: 'vin', headerText: 'Vin', sortable: true},
                {field: 'brand', headerText: 'Brand', sortable: true},
                {field: 'year', headerText: 'Year', sortable: true},
                {field: 'color', headerText: 'Color', sortable: true}
            ],
            datasource: [
                {'brand': 'Volkswagen', 'year': 2012, 'color': 'White', 'vin': 'dsad231ff'},
                {'brand': 'Audi', 'year': 2011, 'color': 'Black', 'vin': 'gwregre345'},
                {'brand': 'Renault', 'year': 2005, 'color': 'Gray', 'vin': 'h354htr'},
                {'brand': 'Opel', 'year': 2015, 'color': 'Yellow', 'vin': 'b941pla'},
                {'brand': 'Bmw', 'year': 2003, 'color': 'Blue', 'vin': 'j6w54qgh'},
                {'brand': 'Mercedes', 'year': 1995, 'color': 'White', 'vin': 'hrtwy34'},
                {'brand': 'Opel', 'year': 2005, 'color': 'Black', 'vin': 'jejtyj'}
            ],
            selectionMode: 'single'
        });
        $("#example-tree").puitree({
            animate: true,
            selectionMode: 'single',
            nodes: [
                {
                    label: 'Documents',
                    data: 'Documents Folder',
                    children: [{
                            label: 'Work',
                            data: 'Work Folder',
                            children: [{label: 'Expenses.doc', iconType: 'doc', data: 'Expenses Document'}, {label: 'Resume.doc', iconType: 'doc', data: 'Resume Document'}]
                        },
                        {
                            label: 'Home',
                            data: 'Home Folder',
                            children: [{label: 'Invoices.txt', iconType: 'doc', data: 'Invoices for this month'}]
                        }]
                },
                {
                    label: 'Pictures',
                    data: 'Pictures Folder',
                    children: [
                        {label: 'barcelona.jpg', iconType: 'picture', data: 'Barcelona Photo'},
                        {label: 'logo.jpg', iconType: 'picture', data: 'PrimeFaces Logo'},
                        {label: 'primeui.png', iconType: 'picture', data: 'PrimeUI Logo'}]
                },
                {
                    label: 'Movies',
                    data: 'Movies Folder',
                    children: [{
                            label: 'Al Pacino',
                            data: 'Pacino Movies',
                            children: [{label: 'Scarface', iconType: 'video', data: 'Scarface Movie'}, {label: 'Serpico', iconType: 'video', data: 'Serpico Movie'}]
                        },
                        {
                            label: 'Robert De Niro',
                            data: 'De Niro Movies',
                            children: [{label: 'Goodfellas', iconType: 'video', data: 'Goodfellas Movie'}, {label: 'Untouchables', iconType: 'video', data: 'Untouchables Movie'}]
                        }]
                }
            ],
            icons: {
                def: {
                    expanded: 'ui-icon-folder-open',
                    collapsed: 'ui-icon-folder-collapsed'
                },
                picture: 'ui-icon-image',
                doc: 'ui-icon-document',
                video: 'ui-icon-video'
            }
        }).puitree('expandNode', $("#example-tree > ul > li:nth-child(2)")).puitree('expandNode', $("#example-tree > ul > li:nth-child(3)"));
        $('#example-menu > ul').puimenu();
    });
</script>