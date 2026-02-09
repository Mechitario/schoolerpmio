'use client'

import React from 'react'
import Link from 'next/link'
import { usePathname } from 'next/navigation'
import {
  LayoutDashboard,
  Users,
  UserCog,
  Wallet,
  GraduationCap,
  BarChart3,
  Settings,
  School,
} from 'lucide-react'

export function SidebarNav() {
  const pathname = usePathname()

  return (
    <nav className="flex-1 overflow-y-auto py-3 px-3 space-y-0">
      <div className="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Site</div>
      <NavLink href="/" icon={<School size={18} />} label="School Website" active={pathname === '/'} />
      <div className="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Portal</div>
      <NavLink href="/dashboard" icon={<LayoutDashboard size={18} />} label="Dashboard" active={pathname === '/dashboard'} />
      <div className="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</div>
      <NavLink href="/students" icon={<Users size={18} />} label="Students" active={pathname.startsWith('/students')} />
      <NavLink href="/staff" icon={<UserCog size={18} />} label="Staff & Teachers" active={pathname.startsWith('/staff')} />
      <NavLink href="/fees" icon={<Wallet size={18} />} label="Fee Tracking" active={pathname.startsWith('/fees')} />
      <div className="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Academic</div>
      <NavLink href="/academics" icon={<GraduationCap size={18} />} label="Exam Results" active={pathname.startsWith('/academics')} />
      <NavLink href="/reports" icon={<BarChart3 size={18} />} label="Financial Reports" active={pathname.startsWith('/reports')} />
      <div className="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">System</div>
      <NavLink href="/settings" icon={<Settings size={18} />} label="Settings" active={pathname.startsWith('/settings')} />
    </nav>
  )
}

function NavLink({ href, icon, label, active }: { href: string; icon: React.ReactNode; label: string; active?: boolean }) {
  return (
    <Link
      href={href}
      className={`flex items-center gap-3 px-3 py-2 rounded text-sm font-medium transition-colors ${
        active
          ? 'bg-blue-600 text-white'
          : 'text-gray-300 hover:bg-gray-700 hover:text-white'
      }`}
    >
      {icon}
      <span>{label}</span>
    </Link>
  )
}
