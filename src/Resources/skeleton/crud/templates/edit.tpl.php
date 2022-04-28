{% extends '<?= $templates_path ?>/base.html.twig' %}
{% import "themes/hyper/saas/macros/dropdown.html.twig" as dropdown %}

{% block title %}
    {{ 'app.titles.edit'|trans({'name': '<?= $route_name ?>.designation.singular'|trans}) }}
{% endblock %}
{% block headline %}
    {{ 'app.headlines.edit'|trans({'name': '<?= $route_name ?>.designation.singular'|trans}) }}
{% endblock %}

{% block entity_body %}
    {{ dropdown.dropdownActions(
        {
            0: {
                'delete': true,
                'path': path('<?= $route_name ?>_delete', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}),
                'csrf_token': csrf_token('delete' ~ <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>)
            }
        }
    ) }}

    <div class="row">
        {{ include('<?= $templates_path ?>/_form.html.twig', {'button_label': 'app.update'|trans}) }}
    </div>

    <a href="{{ path('<?= $route_name ?>_index') }}">{{ 'app.back_to_list'|trans }}</a>
{% endblock %}
