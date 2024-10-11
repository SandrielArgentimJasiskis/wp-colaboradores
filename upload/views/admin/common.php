<?php
    
    function loadAllDependenciesFrontEndColaboradores() {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
        
        ?>
            <style>
                table tbody tr{
                    cursor:pointer;
                }
                table tbody tr:hover {
                    background:#ddd;
                }
                a span.dashicons{
                    vertical-align: text-bottom;
                }
                
                @media screen and (max-width:767px) {
                    label+input{
                        width:100%;
                    }
                    table.fixed{
                        table-layout: auto !important;
                    }
                    
                }
            </style>
        <?php
    }