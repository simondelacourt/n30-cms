<h2>{$lang.adminusers.error}</h2>
<ul class="emessage">
{section name=ln loop=$messages.adduser}
<li>
{if $messages.adduser[ln] == 'exists'}
{$lang.adminusers.errors.exists}
{elseif $messages.adduser[ln] == 'template'}
{$lang.adminusers.errors.template}
{elseif $messages.adduser[ln] == 'language'}
{$lang.adminusers.errors.language}
{elseif $messages.adduser[ln] == 'email'}
{$lang.adminusers.errors.email}
{elseif $messages.adduser[ln] == 'password'}
{$lang.adminusers.errors.password}
{elseif $messages.adduser[ln] == 'username'}
{$lang.adminusers.errors.username}
{/if}</li>
{/section}
</ul>
