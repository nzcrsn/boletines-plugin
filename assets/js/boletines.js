const URL = "https://diocesisdestodgo.org/wp-json/bl-plugin/v1/boletines";

/* =========================================================
   NEWSLETTER SEARCH
   ========================================================= */

/**
 * Request a newsletter from the REST API.
 *
 * @param {string} year
 * @param {string} month
 * @returns {Promise<Object|undefined>}
 */
async function getNewsletter(year, month) {
    console.log("month", month)
    console.log("year", year)
    try {
        const response = await fetch(`${URL}/${year}/${month}`);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error("Error fetching newsletter:", error);
        return undefined;
    }
}


/**
 * Show loader overlay.
 */
function initLoader() {
    const svg_loader_btn = document.getElementById("loader-btn");
    const svg_search = document.getElementById("search-svg");
    const label_button = document.getElementById("label-btn");


    if (!svg_loader_btn) return;
    svg_loader_btn.classList.remove("hidden")
    svg_search.classList.add("hidden");
    label_button.classList.add("hidden");

}

/**
 * Set the attributes belongs to a newsletter 
 * to render it with a particulary container.
 */
function showNewsletter(newsletter, container) {

    /** Boletín' attributes */
    const anchor = document.getElementById("nl-source");
    const image = document.getElementById("nl-thumbnail");

    if (!image || !anchor) return;

    anchor.href = newsletter.href;
    image.src = newsletter.img_src;
    container.dataset.state = "success";
}


/**
 * Set the container'state to "not-found" to
 * render the apropiate asset.
 */
function showNotFound(container) {
    container.dataset.state = "not-found";
}


/** var to set the loading state */
let loading = false;

async function findNewsletter(event) {

    if (loading) return;

    loading = true;
    initLoader();

    /** Boletin's state container: default, not-found, and newsletter states.  */
    const resultContainer = document.getElementById("section-results");

    /** Inputs & Sumbit Button */
    const yearInput = document.querySelector("#year");
    const monthInput = document.querySelector("#month");

    /** Submit Button Attributes */
    const svg_search = document.getElementById("search-svg");
    const label_button = document.getElementById("label-btn");
    const svg_loader_btn = document.getElementById("loader-btn");

    if (
        !yearInput ||
        !monthInput) {
        return;
    }


    try {
        const newsletter = await getNewsletter(
            yearInput.value.trim().substring(0, 4),
            monthInput.value.trim()
        );

        if (!newsletter) {
            svg_loader_btn?.classList.add("hidden");
            svg_search.classList.remove("hidden")
            label_button.classList.remove("hidden")

            showNotFound(resultContainer);
            loading = false;

            return;
        }


        showNewsletter(newsletter, resultContainer);

        svg_loader_btn?.classList.add("hidden");
        svg_search.classList.remove("hidden");
        label_button.classList.remove("hidden");
        loading = false;

    } catch (error) {
        console.error("Error displaying newsletter:", error);
        loading = false;
    }

}


/**
 * Give the results section the same height
 * as the form section.
 */
function setHeightToSectionResults() {
    const formSection = document.getElementById("section-form");
    const resultsSection = document.getElementById("section-results");

    if (!formSection || !resultsSection) {
        return;
    }

    resultsSection.style.height =
        `${formSection.offsetHeight}px`;
}


/* =========================================================
   NEWSLETTER CAROUSEL
   ========================================================= */

let rootContainer = null;
let newsletterItems = [];

let currentIndex = 0;

let newsletterObserver = null;

/*
 * While we're moving the slider through the arrow buttons,
 * the observer should not change currentIndex.
 */
let isProgrammaticScroll = false;

/*
 * Fallback timer for browsers / situations where scrollend
 * isn't available or isn't triggered as expected.
 */
let programmaticScrollTimer = null;


/**
 * Return the absolute horizontal position of a slide
 * inside the scrolling container.
 *
 * This does not depend on offsetParent.
 *
 * @param {HTMLElement} slide
 * @returns {number}
 */
function getSlidePosition(slide) {
    if (!rootContainer) {
        return 0;
    }

    const containerRect =
        rootContainer.getBoundingClientRect();

    const slideRect =
        slide.getBoundingClientRect();

    return (
        rootContainer.scrollLeft +
        slideRect.left -
        containerRect.left
    );
}


/**
 * Furthest position to which the container
 * can physically scroll.
 *
 * @returns {number}
 */
function getMaxScroll() {
    if (!rootContainer) {
        return 0;
    }

    return Math.max(
        0,
        rootContainer.scrollWidth -
        rootContainer.clientWidth
    );
}


/**
 * Get the real scroll position for a given slide.
 *
 * The last slides may not be able to align with the
 * left edge because the container has reached its end.
 * Therefore their requested position is clamped.
 *
 * @param {HTMLElement} slide
 * @returns {number}
 */
function getClampedSlidePosition(slide) {
    const desiredPosition =
        getSlidePosition(slide);

    const maxScroll =
        getMaxScroll();

    return Math.max(
        0,
        Math.min(
            desiredPosition,
            maxScroll
        )
    );
}


/**
 * Navigate directly to a newsletter.
 *
 * Important:
 * This does NOT depend on IntersectionObserver.
 *
 * Therefore the next item does not need to have
 * previously appeared on screen.
 *
 * @param {number} index
 */
function goToSlide(index) {
    if (
        !rootContainer ||
        newsletterItems.length === 0
    ) {
        return;
    }

    /*
     * Clamp index:
     *
     * - never below 0
     * - never above last newsletter
     */
    const targetIndex =
        Math.max(
            0,
            Math.min(
                index,
                newsletterItems.length - 1
            )
        );

    /*
     * Nothing else to navigate to.
     */
    if (
        targetIndex === currentIndex &&
        rootContainer.scrollLeft ===
        getClampedSlidePosition(
            newsletterItems[targetIndex]
        )
    ) {
        return;
    }

    currentIndex = targetIndex;

    const targetSlide =
        newsletterItems[currentIndex];

    const position =
        getClampedSlidePosition(targetSlide);

    updateArrowState(currentIndex);

    /*
     * Prevent IntersectionObserver from modifying
     * currentIndex while smooth scrolling is occurring.
     */
    isProgrammaticScroll = true;

    clearTimeout(programmaticScrollTimer);

    rootContainer.scrollTo({
        left: position,
        behavior: "smooth"
    });

    /*
     * Fallback.
     *
     * scrollend will normally turn this off,
     * but this prevents isProgrammaticScroll from
     * getting stuck forever.
     */
    programmaticScrollTimer = setTimeout(() => {
        isProgrammaticScroll = false;
    }, 800);
}

/**
 * Determine which slide best represents
 * the container's current scroll position.
 *
 * We compare against the CLAMPED positions rather
 * than raw slide.left values.
 *
 * This is important near the end of the carousel.
 *
 * @returns {number}
 */
function getClosestSlideIndex() {
    if (
        !rootContainer ||
        newsletterItems.length === 0
    ) {
        return 0;
    }

    const currentScroll =
        rootContainer.scrollLeft;

    let closestIndex = 0;
    let closestDistance = Infinity;

    newsletterItems.forEach((slide, index) => {
        const slidePosition =
            getClampedSlidePosition(slide);

        const distance =
            Math.abs(
                currentScroll -
                slidePosition
            );
        /*
         * <= intentionally favors the later slide
         * if two final slides share the same
         * clamped maxScroll position.
         */
        if (distance <= closestDistance) {
            closestDistance = distance;
            closestIndex = index;
        }
    });
    return closestIndex;
}

/**
 * Synchronize currentIndex after manual scrolling.
 */
function syncCurrentIndex() {
    if (isProgrammaticScroll) {
        return;
    }

    currentIndex =
        getClosestSlideIndex();

    updateArrowState(currentIndex);
}

function updateArrowState(idx) {
    if (idx === 0) {
        document.getElementById("arrow-left").classList.add("disabled");
    } else {
        document.getElementById("arrow-left").classList.remove("disabled");

    }
    if (idx === newsletterItems.length - 1) {
        document.getElementById("arrow-right").classList.add("disabled");
    } else {
        document.getElementById("arrow-right").classList.remove("disabled");

    }
}

/**
 * Create IntersectionObserver.
 *
 * Its responsibility is ONLY to notify us that
 * the user has manually changed what is visible.
 *
 * It never performs the scrolling itself.
 */
function createItemObserver() {
    if (
        !rootContainer ||
        newsletterItems.length === 0 ||
        !("IntersectionObserver" in window)
    ) {
        return;
    }

    if (newsletterObserver) {
        newsletterObserver.disconnect();
    }

    newsletterObserver =
        new IntersectionObserver(
            () => {
                syncCurrentIndex();
            },
            {
                root: rootContainer,

                /*
                 * Several thresholds give us useful
                 * callbacks while the user manually
                 * drags / scrolls the carousel.
                 */
                threshold: [
                    0,
                    0.25,
                    0.5,
                    0.75,
                    1
                ]
            }
        );

    newsletterItems.forEach((item) => {
        newsletterObserver.observe(item);
    });
}

/**
 * Initialize previous / next buttons.
 */
function initArrowButtons() {
    const arrowLeft =
        document.getElementById("arrow-left");

    const arrowRight =
        document.getElementById("arrow-right");

    if (!arrowLeft || !arrowRight) {
        return;
    }


    arrowRight.addEventListener(
        "click",
        () => {
            goToSlide(currentIndex + 1);
        }
    );


    arrowLeft.addEventListener(
        "click",
        () => {
            goToSlide(currentIndex - 1);
        }
    );
}

/**
 * Handle the end of programmatic scrolling.
 */
function initScrollEndDetection() {
    if (!rootContainer) {
        return;
    }

    /*
     * Native scrollend.
     */
    rootContainer.addEventListener(
        "scrollend",
        () => {
            clearTimeout(programmaticScrollTimer);
            isProgrammaticScroll = false;
        }
    );
}

/**
 * When the layout changes, newsletter positions
 * may also change.
 *
 * Re-sync currentIndex after resize.
 */
function initResizeHandling() {
    let resizeTimer;

    window.addEventListener(
        "resize",
        () => {
            clearTimeout(resizeTimer);

            resizeTimer = setTimeout(() => {
                if (!rootContainer) {
                    return;
                }

                /*
                 * Recalculate which newsletter corresponds
                 * to the current position.
                 */
                isProgrammaticScroll = false;

                currentIndex =
                    getClosestSlideIndex();
            }, 150);
        }
    );
}

const MIN_YEAR = 2021
const MAX_YEAR = (new Date()).getFullYear();

function validateInputValue(value) {
    console.log("value:", value)
    if (isNaN(Number(value))) return false;
    if (year.value === "") return false;
    if (Number(value) < MIN_YEAR) return false;
    if (Number(value) > MAX_YEAR) return false;
    return true;
}

function validateSelectedValue(value) {
    if (month.value === "") return false;
    return true;
}

let validInput = "";
let validSelectedOption = "";

function tryEnableButton() {
    if (validInput && validSelectedOption) {
        document.getElementById("btn").classList.remove("disabled");
    } else {
        document.getElementById("btn").classList.add("disabled");
    }
}

function initInputDetection() {
    year = document.getElementById("year");
    month = document.getElementById("month");

    year.addEventListener("input", () => {
        validInput = validateInputValue(year.value);
        console.log(validInput);
        tryEnableButton();
    });

    month.addEventListener("change", () => {
        validSelectedOption = validateSelectedValue(month.value);
        tryEnableButton();
    });
}

/* =========================================================
   INITIALIZATION
   ========================================================= */

window.addEventListener("load", () => {
    const submitButton =
        document.querySelector("#btn");

    rootContainer =
        document.getElementById(
            "newsletters-container"
        );

    if (submitButton) {
        submitButton.addEventListener(
            "click",
            findNewsletter
        );
    }




    /*
     * Carousel does not exist on this page.
     */
    if (!rootContainer) {
        return;
    }


    /*
     * Query the newsletters ONCE.
     *
     * No need to call querySelectorAll every time
     * the arrows are clicked.
     */
    newsletterItems = Array.from(rootContainer.querySelectorAll(
        ".newsletter-item"
    )
    );


    if (newsletterItems.length === 0) {
        return;
    }


    createItemObserver();

    initArrowButtons();

    initScrollEndDetection();

    initResizeHandling();

    initInputDetection();
});