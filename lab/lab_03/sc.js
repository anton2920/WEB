function printGuitar(arGuitars, selector)
{
    /* Initializing variables */
    const startTemplate = '<h4> Каталог: </h4>';
    const lileTemplate = '<div class="item"><div><img src="{{img}}"></div><ul><li>{{name}}</li><li>{{year}}</li><li>{{body}}</li><li>{{country}}</li><li>{{type}}</li><ul></div>';
    const endTemplate = '</table>';
    
    let output = startTemplate;
    
    /* Main part */
    for (let item of arGuitars) {
        let tmpLine;
        tmpLine = lileTemplate.replace('{{name}}', item.name);
        tmpLine = tmpLine.replace('{{year}}',     item.year);
        tmpLine = tmpLine.replace('{{img}}',     item.img);
        tmpLine = tmpLine.replace('{{body}}',      item.body);
        tmpLine = tmpLine.replace('{{country}}',   item.country);
        tmpLine = tmpLine.replace('{{type}}',   item.type);
        output += tmpLine;
    };
    
    output += endTemplate;
    $(selector).html(output);
}

function printFilters(arProperties, selector)
{
    /* Initializing variables */
    const startTemplate = '<br>{{name}}<br>';
    const lileTemplate  = '<label><input type="checkbox" id="{{name}}" name="{{prop}}" value="{{name}}">{{name}}</label><br>';
    const endTemplate   = '';
    let output = '';

    /* Main part */
    for (let prop in arProperties) {
        let tmpLine = startTemplate.replace('{{name}}', arProperties[prop]);
        let vals    = [];

        for (let guitar of guitars) {
            if (!vals.includes(guitar[prop])) {
                vals.push(guitar[prop]);
            }
        }
    
        vals.sort();
        vals.forEach(function(item) {
            tmpLine += lileTemplate.replace("{{prop}}", prop ).replaceAll("{{name}}",item);
        });
        
        output += tmpLine;
    
    };
    
    output += endTemplate;
    $(selector).html(output);
}

function readCurFilters(properties)
{
    /* Initializing variables */
    let result = [];

    /* Main part */
    for (let prop in properties) {
        let searchIDs = $("#filters input[name='"+prop+"']:checkbox:checked").map(function(){
            return $(this).val();
        }).get();
    
        result[prop] = searchIDs;
    }
    
    /* Returning value */
    return result;
}

function applyFilters(data, filter, properties)
{
    /* Initializing variables */
    let result = [];

    /* Main part */
    for (let guitar of data) {
        let ok = true;
        for (let prop in properties) {
            if (!filter[prop].length) {
                continue;
            }

            if (filter[prop].indexOf(guitar[prop]) == -1) {
                ok = false;
            }
        }
        
        if (ok) {
            result.push(guitar);
        };
    };

    /* Returning value */
    return result;
}

function getEmptyFilters(properties)
{
    /* Initializing variables */
    let filters = [];

    /* Main part */
    for (let prop in properties) {
        let searchIDs = $("#filters input[name='"+prop+"']:not(:checked)").map(function() {
            return $(this).val();
        }).get();
    
        filters[prop] = searchIDs;
    }

    /* Returning value */
    return filters;
}

function closeEmptyCheckBox(curFilter, filters, guitars, properties)
{
    /* Main part */
    for (let prop in properties) {
        for (let filter in filters[prop]) {
            curFilter[prop].push(filters[prop][filter]);
            if (applyFilters(guitars, curFilter, properties).length === 0) {
                document.getElementById(filters[prop][filter]).setAttribute('disabled', 'true');
            } else {
                document.getElementById(filters[prop][filter]).removeAttribute('disabled');
            }
            curFilter[prop].pop();
        }
    }
}

$(document).ready(function()
{
    /* Main part */
    printGuitar(guitars, '#elements');
    printFilters(properties, '#filters');

    $('#filters input').change(function()
    {
        let curFilter      = readCurFilters(properties);
        let filtredGuitars = applyFilters(guitars, curFilter, properties);
        let unchecked      = getEmptyFilters(properties);
        closeEmptyCheckBox(curFilter, unchecked,guitars, properties);

        printGuitar(filtredGuitars, '#elements');
    });
});
