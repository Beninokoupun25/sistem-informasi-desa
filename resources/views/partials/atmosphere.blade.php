<svg class="{{ $class ?? 'atmosphere' }}" viewBox="0 0 1200 700" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
    <defs>
        <filter id="fa-{{ $id ?? 'a' }}"><feGaussianBlur stdDeviation="52"/></filter>
        <filter id="fb-{{ $id ?? 'a' }}"><feGaussianBlur stdDeviation="34"/></filter>
    </defs>
    <ellipse cx="170"  cy="170" rx="320" ry="88"  fill="#d7f3e2" opacity="0.9"  filter="url(#fa-{{ $id ?? 'a' }})"/>
    <ellipse cx="880"  cy="115" rx="360" ry="80"  fill="#cdeed9" opacity="0.9"  filter="url(#fa-{{ $id ?? 'a' }})"/>
    <ellipse cx="510"  cy="260" rx="230" ry="68"  fill="#c2ecd4" opacity="0.8"  filter="url(#fb-{{ $id ?? 'a' }})"/>
    <ellipse cx="1090" cy="240" rx="195" ry="60"  fill="#cdeed9" opacity="0.85" filter="url(#fb-{{ $id ?? 'a' }})"/>
    <ellipse cx="55"   cy="340" rx="170" ry="52"  fill="#d7f3e2" opacity="0.9"  filter="url(#fa-{{ $id ?? 'a' }})"/>
    <ellipse cx="620"  cy="88"  rx="270" ry="58"  fill="#c2ecd4" opacity="0.8"  filter="url(#fa-{{ $id ?? 'a' }})"/>
    <ellipse cx="350"  cy="380" rx="140" ry="44"  fill="#d7f3e2" opacity="0.85" filter="url(#fb-{{ $id ?? 'a' }})"/>
</svg>
