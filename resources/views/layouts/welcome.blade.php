{{-- layouts/welcome.blade.php --}}
@if (!empty($welcome))
    <div id="welcome-alert" class="alert alert-success alert-dismissible fade show text-center m-3" role="alert">
        {{ $welcome }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (!empty($username))
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="welcomeModalLabel">👋 Welcome!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Hello {{ $username }},</h3>
                    <p>We're thrilled to have you at <strong>Dushal CTO</strong>. Let's start your coding journey with passion and purpose!</p>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="welcomeModalLabel">👋 Hello Visitor!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Hello there,</h3>
                    <p>We're thrilled to have you at <strong>Dushal CTO</strong>. Let's start your coding journey with passion and purpose!</p>
                </div>
            </div>
        </div>
    </div>
@endif
