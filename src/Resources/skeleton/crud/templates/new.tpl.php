{% extends 'base.index.html.twig' %}

{% block title %}
    {{ 'app.titles.new'|trans({'name': '<?= $templates_path ?>.designation.singular'|trans}) }}
{% endblock %}
{% block headline %}
    {{ 'app.headlines.new'|trans({'name': '<?= $templates_path ?>.designation.singular'|trans}) }}
{% endblock %}

{% block index_body %}
    {{ include('<?= $templates_path ?>/_form.html.twig') }}

    <a href="{{ path('<?= $route_name ?>_index') }}">{{ 'app.back_to_list'|trans }}</a>
{% endblock %}
