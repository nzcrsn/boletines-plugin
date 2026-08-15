

const URL = "http://localhost:8080/wp-json/bl-plugin/v1/boletines";

/**
 * @description
 * Request to server to a Newsletter
 * @param {string} year 
 * @param {string} month 
 * @returns 
 */
async function get_newsletter(year, month) {
    try {
        const response = await fetch(`${URL}/${year}/${month}`);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const result = await response.json();
        return result;
    } catch (error) {
        console.error(error.message);
    }
}


/**
 * @description
 * - Function to search a newsletter
 */
async function find_newsletter() {
    const year_input_value = document.querySelector("#year")?.value;
    const month_input_value = document.querySelector("#month")?.value;

    const img_el = document.querySelector("#nl-thumbnail");
    const anchor_el = document.querySelector("#nl-source");

    try {
        const newsletter = await get_newsletter(year_input_value, month_input_value);
        anchor_el.setAttribute('href', newsletter.href);
        img_el.setAttribute('src', newsletter.img_src);
    } catch (e) {
        console.error(e);
    }

}
window.addEventListener("load", async () => {
    const submit_btn_el = document.querySelector("#btn");
    submit_btn_el.addEventListener("click", find_newsletter)
})





