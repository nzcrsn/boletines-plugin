<section class="newsletter-search">
    <header class="newsletter-header">
        <h2 class="heading"><span>¿Interesado en boletines de años anteriores?</span> Busca tu boletín.</h2>
        <p class="supporting-text">Escribe el año(*) y selecciona el mes de publicación del boletín que buscas. </p>
    </header>
    <div class="search-nl-container">
        <div id="section-form" class="section-form">
            <div class="input-field">
                <label for="year">Año</label>
                <input id="year" inputmode="numeric" min="2021" max="2026">
                <p class="warning-label">(*) Año mínimo de consulta: 2021.</p>
            </div>

            <div class="input-field">
                <label for="month">Mes</label>
                <select class="select-field" id="month" name="month">
                    <option value="">Selecciona un mes</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>

            <div class="button-field">
                <button name="Buscar" id="btn" type="button" class="disabled">
                    <svg id="loader-btn" class="loader-svg hidden" viewBox="0 0 40 40">
                        <circle class="c1 circle" cx="5" cy="20" r="5" />
                        <circle class="c2 circle" cx="20" cy="20" r="5" />
                        <circle class="c3 circle" cx="35" cy="20" r="5" />
                    </svg>

                    <svg id="search-svg" class="search-svg" width="12" height="12" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" d="M13.25 13.25L10.35 10.35M11.9167 6.58333C11.9167 9.52885 9.52885 11.9167 6.58333 11.9167C3.63781 11.9167 1.25 9.52885 1.25 6.58333C1.25 3.63781 3.63781 1.25 6.58333 1.25C9.52885 1.25 11.9167 3.63781 11.9167 6.58333Z" stroke="#F5F5F5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p id="label-btn" class="label-button">Buscar</p>
                </button>
            </div>
        </div>
        <div id="section-results" class="searched-nl-item section-results" data-state="initial">

            <svg class="item-placeholder result-state" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 42 42" style="filter: drop-shadow(rgba(33, 33, 33, 0.2) 0px 0px 1px);">
                <rect width="42" height="42" fill="#fff" rx="2" ry="2" />
                <path fill="#212121" fill-rule="evenodd" transform="translate(7.35 7.35) scale(0.65)" d="M23 11h-8c-1.1 0-1.99.9-1.99 2L13 29c0 1.1.89 2 1.99 2H27c1.1 0 2-.9 2-2V17l-6-6Zm2 16h-8v-2h8v2Zm0-4h-8v-2h8v2Zm-3-5v-5.5l5.5 5.5H22Z" clip-rule="evenodd" opacity="0.2" />
                <text class="text" x="50%" y="85%">Tu boletín aparecerá aquí</text>
            </svg>

            <svg class="not-found result-state" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42 42" fill="none" style="filter: drop-shadow(rgba(33, 33, 33, 0.2) 0px 0px 1px);">
                <rect width="42" height="42" fill="#fff" rx="2" ry="2" />
                <path fill="#212121" transform=" translate(14.35 14.35) scale(0.60)" fill-rule="evenodd" clip-rule="evenodd" d="M24 12C24 18.6274 18.6274 24 12 24C5.37258 24 0 18.6274 0 12C0 5.37258 5.37258 0 12 0C18.6274 0 24 5.37258 24 12ZM10.5 7.5V12C10.5 12.8284 11.1716 13.5 12 13.5C12.8284 13.5 13.5 12.8284 13.5 12V7.5C13.5 6.67157 12.8284 6 12 6C11.1716 6 10.5 6.67157 10.5 7.5ZM12 18C12.8284 18 13.5 17.3284 13.5 16.5C13.5 15.6716 12.8284 15 12 15C11.1716 15 10.5 15.6716 10.5 16.5C10.5 17.3284 11.1716 18 12 18Z" />
                <text class="text" x="50%" y="85%">¡No encontramos tú boletín!</text>
            </svg>

            <a class="nl-result result-state"
                id="nl-source"
                target="_blank"
                rel="noopener noreferrer">
                <img id="nl-thumbnail">
            </a>

        </div>

    </div>
</section>