<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .container {
                width: 70%;
                text-align: center;
                margin: auto;
                font-family: sans-serif;
            }
            
            .header, .footer {
                text-align: center;
                background-color: #1cc88a
            }
            
            .header-container, .footer-container {
                margin: auto;
                padding: 1rem 0.5rem;
                color: #ffffff;
            }
            
            .header-container img, .footer-container p {
                vertical-align: middle;
            }
            
            .content {
                padding: 2rem 1rem;
                text-align: center;
                border: 1px solid #1cc88a;
            }

            .btn {
                display: inline-block;
                font-weight: 400;
                color: #858796;
                text-align: center;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: transparent;
                border: 1px solid transparent;
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: 0.35rem;
                transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            @media (prefers-reduced-motion: reduce) {
                .btn {
                    transition: none;
                }
            }

            .btn:hover {
                color: #858796;
                text-decoration: none;
            }

            .btn:focus, .btn.focus {
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            }

            a.btn.disabled,
                fieldset:disabled a.btn {
                pointer-events: none;
            }

            .btn-primary {
                color: #ffffff;
                background-color: #4e73df;
                border-color: #4e73df;
            }

            .btn-primary:hover {
                color: #ffffff;
                background-color: #2e59d9;
                border-color: #2653d4;
            }

            .btn-primary:focus, .btn-primary.focus {
                color: #ffffff;
                background-color: #2e59d9;
                border-color: #2653d4;
                box-shadow: 0 0 0 0.2rem rgba(105, 136, 228, 0.5);
            }

            .btn-primary.disabled, .btn-primary:disabled {
                color: #fff;
                background-color: #4e73df;
                border-color: #4e73df;
            }

            .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active,
            .show > .btn-primary.dropdown-toggle {
                color: #fff;
                background-color: #2653d4;
                border-color: #244ec9;
            }

            .btn-primary:not(:disabled):not(.disabled):active:focus, .btn-primary:not(:disabled):not(.disabled).active:focus,
            .show > .btn-primary.dropdown-toggle:focus {
                box-shadow: 0 0 0 0.2rem rgba(105, 136, 228, 0.5);
            }
            
            @media screen and (max-width: 640px) {
                .container {
                    width: 100%;
                    border-radius: 10%;
                }
                .btn {
                    display: inline-block;
                    font-weight: 400;
                    color: #858796;
                    text-align: center;
                    vertical-align: middle;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    background-color: transparent;
                    border: 1px solid transparent;
                    padding: 0.375rem 0.75rem;
                    font-size: 1rem;
                    line-height: 1.5;
                    border-radius: 0.35rem;
                    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                }

                @media (prefers-reduced-motion: reduce) {
                    .btn {
                        transition: none;
                    }
                }

                .btn:hover {
                    color: #858796;
                    text-decoration: none;
                }

                .btn:focus, .btn.focus {
                    outline: 0;
                    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
                }

                a.btn.disabled,
                    fieldset:disabled a.btn {
                    pointer-events: none;
                }

                .btn-primary {
                    color: #ffffff;
                    background-color: #4e73df;
                    border-color: #4e73df;
                }

                .btn-primary:hover {
                    color: #ffffff;
                    background-color: #2e59d9;
                    border-color: #2653d4;
                }

                .btn-primary:focus, .btn-primary.focus {
                    color: #ffffff;
                    background-color: #2e59d9;
                    border-color: #2653d4;
                    box-shadow: 0 0 0 0.2rem rgba(105, 136, 228, 0.5);
                }

                .btn-primary.disabled, .btn-primary:disabled {
                    color: #fff;
                    background-color: #4e73df;
                    border-color: #4e73df;
                }

                .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active,
                .show > .btn-primary.dropdown-toggle {
                    color: #fff;
                    background-color: #2653d4;
                    border-color: #244ec9;
                }

                .btn-primary:not(:disabled):not(.disabled):active:focus, .btn-primary:not(:disabled):not(.disabled).active:focus,
                .show > .btn-primary.dropdown-toggle:focus {
                    box-shadow: 0 0 0 0.2rem rgba(105, 136, 228, 0.5);
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="header-container">
                    <h1>Davinti Affiliate System</h1>
                </div>
            </div>
            <div class="content">
                <h2>Hello {{ $nama_lengkap }}</h2>
                <br/>
                <h4>Please Click The Button Below to Reset your Password:</h4>
                <br/>
                <a href="{{ $link_reset }}" class="btn btn-primary" target="_blank">Reset Password</a>
            </div>
            <div class="footer">
                <div class="footer-container">
                    <h2>Thank You</h2>
                </div>
            </div>
        </div>
    </body>
</html>