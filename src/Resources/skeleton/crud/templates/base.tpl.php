{% extends 'themes/hyper/saas/base.entity.html.twig' %}

{% block entity_profile %}

<div class="col-xxl-2 col-xl-6 order-xl-1 order-xxl-2">
    <div class="card">
        <div class="card-body">

            <div class="mt-3 text-center">
                <img src="{{ asset('images/users/avatar-5.jpg') }}" alt="shreyu"
                     class="img-thumbnail avatar-lg rounded-circle"/>
                <h4>asdasdasd</h4>
                <button class="btn btn-primary btn-sm mt-1"><i class='uil uil-envelope-add me-1'></i>Send Email
                </button>
                <p class="text-muted mt-2 font-14">Last Interacted: <strong>Few hours back</strong></p>
            </div>

            <div class="mt-3">
                <hr class=""/>

                <p class="mt-4 mb-1"><strong><i class='uil uil-at'></i> Email:</strong></p>
                <p>support@coderthemes.com</p>

                <p class="mt-3 mb-1"><strong><i class='uil uil-phone'></i> Phone Number:</strong></p>
                <p>+1 456 9595 9594</p>

                <p class="mt-3 mb-1"><strong><i class='uil uil-location'></i> Location:</strong></p>
                <p>California, USA</p>

                <p class="mt-3 mb-1"><strong><i class='uil uil-globe'></i> Languages:</strong></p>
                <p>English, German, Spanish</p>

                <p class="mt-3 mb-2"><strong><i class='uil uil-users-alt'></i> Groups:</strong></p>
                <p>
                    <span class="badge badge-success-lighten p-1 font-14">Work</span>
                    <span class="badge badge-primary-lighten p-1 font-14">Friends</span>
                </p>
            </div>


        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div> <!-- end col -->
{% endblock %}

{% block entity_menu %}

<div class="col-xxl-2 col-xl-6 order-xl-1 order-xxl-2">
    <div class="card">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-bordered">
                <li class="nav-item">
                    <a href="#allUsers" data-bs-toggle="tab" aria-expanded="false" class="nav-link active py-2">
                        All
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#favUsers" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2">
                        Favourties
                    </a>
                </li>
            </ul> <!-- end nav-->
            <div class="tab-content">
                <div class="tab-pane show active p-3" id="newpost">
                    {% set menu = build_<?= $entity_twig_var_singular ?>_menu('<?= $entity_twig_var_singular ?>', [], {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) %}
                    {{ knp_menu_render(menu) }}
                </div> <!-- end Tab Pane-->
            </div> <!-- end tab content-->
        </div> <!-- end card-body-->
    </div> <!-- end card-body-->
</div> <!-- end col -->
{% endblock %}
