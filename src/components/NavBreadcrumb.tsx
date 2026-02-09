'use client'

import React from 'react'
import Link from 'next/link'
import { usePathname } from 'next/navigation'

const labels: Record<string, string> = {
  '/': 'Home',
  '/dashboard': 'Dashboard',
  '/students': 'Students',
  '/staff': 'Staff & Teachers',
  '/fees': 'Fee Tracking',
  '/academics': 'Exam Results',
  '/reports': 'Financial Reports',
  '/settings': 'Settings',
}

export function NavBreadcrumb() {
  const pathname = usePathname()
  const segments = pathname === '/' ? [] : pathname.split('/').filter(Boolean)
  const pathSoFar: string[] = []
  const crumbs = segments.map((seg) => {
    pathSoFar.push(seg)
    const path = '/' + pathSoFar.join('/')
    const label = labels[path] || (seg.charAt(0).toUpperCase() + seg.slice(1))
    return { path, label }
  })
  if (pathname !== '/' && crumbs.length > 0 && crumbs[0]?.path !== '/') {
    crumbs.unshift({ path: '/', label: 'Home' })
  }
  if (pathname === '/') {
    crumbs.push({ path: '/', label: 'Home' })
  }

  return (
    <nav className="flex items-center gap-1 text-sm text-gray-500">
      {crumbs.map((crumb, i) => (
        <React.Fragment key={crumb.path}>
          {i > 0 && <span className="text-gray-400">/</span>}
          {i === crumbs.length - 1 ? (
            <span className="text-gray-900 font-medium">{crumb.label}</span>
          ) : (
            <Link href={crumb.path} className="hover:text-gray-700">
              {crumb.label}
            </Link>
          )}
        </React.Fragment>
      ))}
    </nav>
  )
}
