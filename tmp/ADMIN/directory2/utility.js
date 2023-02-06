function collect_field_ids(form_id) {
    let input_elements = document.querySelectorAll(`input`);
    let ids = [];
    input_elements.forEach((el)=>{ids.push(el.id)})
    return ids;
}
// Get partially called function
function bind_partial_last(f, ...last_args) {
    return function(...remaining_args) {
        return f(...remaining_args, ...last_args);
    }
}