<div class="sidebar" data-color="green" data-background-color="white"
	data-image="{{ asset('material') }}/img/sidebar-1.jpg">
	<div class="sidebar-wrapper">
		<ul class="nav">

			{{-- LOGO --}}
			<li class="nav-item">
				<a class="nav-link" href="{{ route('home') }}">
					<i>
						<img style="width:195px" src="{{ asset('material') }}/img/logo-horizontal.png">
					</i>
					<p><br></p>
				</a>
			</li>

			@php
				// quais páginas deixam cada menu aberto
				$financeiroPages = [
					'financeiro-dashboard',
					'financeiro-contas-pagar',
					'financeiro-contas-receber',
					'financeiro-relatorios',
				];

				$financeiroOpen = in_array($activePage ?? '', $financeiroPages);

				$cadastrosOpen = in_array($activePage ?? '', [
					'clientes',
					'produtos',
					'users',
					'fornecedores',
					'Instituições',
				]);

				$propostasOpen = in_array($activePage ?? '', [
					'propostas',
					'propostas-usuario',
					'esteira',
					'acessos-externos',
				]);

				$producaoOpen = in_array($activePage ?? '', [
					'producao-geral',
					'producao-usuario',
				]);

				$adminOpen = in_array($activePage ?? '', [
					'roles',
					'status',
				]);
			@endphp

			{{-- ===============================FINANCEIRO================================ --}}
			@can('financeiro.dashboard')
				<li class="nav-item {{ $financeiroOpen ? ' active' : '' }}">
					<a class="nav-link" data-toggle="collapse" href="#menuFinanceiro"
						aria-expanded="{{ $financeiroOpen ? 'true' : 'false' }}">
						<i class="material-icons">account_balance</i>
						<p>Financeiro
							<b class="caret"></b>
						</p>
					</a>

					<div class="collapse {{ $financeiroOpen ? 'show' : '' }}" id="menuFinanceiro">
						<ul class="nav">
							{{-- Dashboard --}}
							<li class="nav-item{{ ($activePage ?? '') == 'financeiro-dashboard' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('financeiro.dashboard') }}">
									<i class="material-icons">dashboard</i>
									<span class="sidebar-normal">Dashboard</span>
								</a>
							</li>

							{{-- Contas a Pagar --}}
							@can('lancamentos.index')
								<li class="nav-item{{ ($activePage ?? '') == 'financeiro-contas-pagar' ? ' active' : '' }}">
									<a class="nav-link" href="{{ route('financeiro.contas-pagar') }}">
										<i class="material-icons">trending_down</i>
										<span class="sidebar-normal">Contas a Pagar</span>
									</a>
								</li>

								{{-- Contas a Receber --}}
								<li class="nav-item{{ ($activePage ?? '') == 'financeiro-contas-receber' ? ' active' : '' }}">
									<a class="nav-link" href="{{ route('financeiro.contas-receber') }}">
										<i class="material-icons">trending_up</i>
										<span class="sidebar-normal">Contas a Receber</span>
									</a>
								</li>
							@endcan

							{{-- Relatórios --}}
							@can('financeiro.relatorios')
								<li class="nav-item{{ ($activePage ?? '') == 'financeiro-relatorios' ? ' active' : '' }}">
									<a class="nav-link" href="{{ route('financeiro.relatorios') }}">
										<i class="material-icons">assessment</i>
										<span class="sidebar-normal">Relatórios</span>
									</a>
								</li>
							@endcan
						</ul>
					</div>
				</li>
			@endcan

			{{-- ===============================CADASTROS================================= --}}
			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#cadastros"
					aria-expanded="{{ $cadastrosOpen ? 'true' : 'false' }}">
					<i class="material-icons">library_books</i>
					<p>{{ __('Cadastros') }}
						<b class="caret"></b>
					</p>
				</a>
				<div class="collapse {{ $cadastrosOpen ? 'show' : '' }}" id="cadastros">
					<ul class="nav">
						@can('clientes.index')
							<li class="nav-item{{ ($activePage ?? '') == 'clientes' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('clientes.index') }}">
									<i class="material-icons">recent_actors</i>
									<span class="sidebar-normal">{{ __('Clientes') }}</span>
								</a>
							</li>
						@endcan

						@can('produtos.index')
							<li class="nav-item{{ ($activePage ?? '') == 'produtos' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('produtos.index') }}">
									<i class="material-icons">work</i>
									<span class="sidebar-normal">{{ __('Produtos') }}</span>
								</a>
							</li>
						@endcan

						@can('fornecedores.index')
							<li class="nav-item{{ ($activePage ?? '') == 'fornecedores' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('fornecedores.index') }}">
									<i class="material-icons">local_shipping</i>
									<span class="sidebar-normal">{{ __('Fornecedores') }}</span>
								</a>
							</li>
						@endcan

						@can('bancos.index')
							<li class="nav-item{{ ($activePage ?? '') == 'Instituições' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('bancos.index') }}">
									<i class="material-icons">account_balance_wallet</i>
									<span class="sidebar-normal">{{ __('Instituições') }}</span>
								</a>
							</li>
						@endcan

						@can('users.index')
							<li class="nav-item{{ ($activePage ?? '') == 'users' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('users.index') }}">
									<i class="material-icons">group</i>
									<span class="sidebar-normal">{{ __('Usuários') }}</span>
								</a>
							</li>
						@endcan
					</ul>
				</div>
			</li>

			{{-- ===============================PROPOSTAS================================= --}}
			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#propostasMenu"
					aria-expanded="{{ $propostasOpen ? 'true' : 'false' }}">
					<i class="material-icons">request_quote</i>
					<p>{{ __('Propostas') }}
						<b class="caret"></b>
					</p>
				</a>

				<div class="collapse {{ $propostasOpen ? 'show' : '' }}" id="propostasMenu">
					<ul class="nav">
						<li class="nav-item{{ ($activePage ?? '') == 'propostas' ? ' active' : '' }}">
							<a class="nav-link" href="{{ route('propostas.index') }}">
								<i class="material-icons">pending_actions</i>
								<span class="sidebar-normal">{{ __('Todas as Propostas') }}</span>
							</a>
						</li>
						<li class="nav-item{{ ($activePage ?? '') == 'esteira' ? ' active' : '' }}">
							<a class="nav-link" href="{{ route('esteira.index') }}">
								<i class="material-icons">format_indent_increase</i>
								<span class="sidebar-normal">{{ __('Esteira de Propostas')  }}</span>
							</a>
						</li>

						@can('acessos-externos.index')
							<li class="nav-item{{ ($activePage ?? '') == 'acessos-externos' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('acessos-externos.index') }}">
									<i class="material-icons">vpn_key</i>
									<span class="sidebar-normal">Acessos Externos</span>
								</a>
							</li>
						@endcan
					</ul>
				</div>
			</li>

			{{-- ===============================PRODUÇÃO================================= --}}
			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#producaoMenu"
					aria-expanded="{{ $producaoOpen ? 'true' : 'false' }}">
					<i class="material-icons">assessment</i>
					<p>{{ __('Produção') }}
						<b class="caret"></b>
					</p>
				</a>
				<div class="collapse {{ $producaoOpen ? 'show' : '' }}" id="producaoMenu">
					<ul class="nav">
						@can('producao.index')
							<li class="nav-item{{ ($activePage ?? '') == 'producao-geral' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('producao.index') }}">
									<i class="material-icons">bar_chart</i>
									<span class="sidebar-normal">{{ __('Produção Geral') }}</span>
								</a>
							</li>

							<li class="nav-item{{ ($activePage ?? '') == 'producao-usuario' ? ' active' : '' }}">
								<a class="nav-link" href="{{ route('producao.usuario') }}">
									<i class="material-icons">person_search</i>
									<span class="sidebar-normal">{{ __('Produção por Usuário') }}</span>
								</a>
							</li>
						@endcan
					</ul>
				</div>
			</li>

			{{-- ===============================CARTEIRA================================= --}}
			@can('carteiras.index')
				<li class="nav-item{{ ($activePage ?? '') == 'carteiras' ? ' active' : '' }}">
					<a class="nav-link" href="{{ route('carteiras.index') }}">
						<i class="material-icons">view_list</i>
						<p>{{ __('Carteira') }}</p>
					</a>
				</li>
			@endcan

			{{-- ===============================ADMINISTRAÇÃO================================= --}}
			@if(Auth::user() && (Auth::user()->can('roles.index') || Auth::user()->can('status.index')))
				<li class="nav-item">
					<a class="nav-link" data-toggle="collapse" href="#administracao"
						aria-expanded="{{ $adminOpen ? 'true' : 'false' }}">
						<i class="material-icons">settings</i>
						<p>{{ __('Configurações') }}
							<b class="caret"></b>
						</p>
					</a>
					<div class="collapse {{ $adminOpen ? 'show' : '' }}" id="administracao">
						<ul class="nav">

							@can('roles.index')
								<li class="nav-item{{ ($activePage ?? '') == 'roles' ? ' active' : '' }}">
									<a class="nav-link" href="{{ route('roles.index') }}">
										<i class="material-icons">manage_accounts</i>
										<span class="sidebar-normal">{{ __('Permissões') }}</span>
									</a>
								</li>
							@endcan

							@can('status.index')
								<li class="nav-item{{ ($activePage ?? '') == 'status' ? ' active' : '' }}">
									<a class="nav-link" href="{{ route('status.index') }}">
										<i class="material-icons">rule</i>
										<span class="sidebar-normal">{{ __('Status') }}</span>
									</a>
								</li>
							@endcan

						</ul>
					</div>
				</li>
			@endif

		</ul>
	</div>
</div>