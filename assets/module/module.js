(() => {
    /**
     * initializeBlock: +++MODULE+++
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @return  void
     */

    const scriptName = "+++MODULE+++";

    var initializeBlock = (block) => {
        const module = window.acf ? block[0] : block;
    }

    document.addEventListener("DOMContentLoaded", () => {
        const elements = Array.from(document.getElementsByClassName(`${scriptName}`)); 
        elements.forEach(element => {
            initializeBlock( element );
        });
    });

    if( window.acf ) {
        window.acf.addAction( `render_block_preview/type=${scriptName}`, initializeBlock );
    }
})();
