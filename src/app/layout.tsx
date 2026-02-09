import React from 'react'
import Link from 'next/link'
import { Bell, Search, Menu, School, LogOut, ChevronDown } from 'lucide-react'
import { SidebarNav } from '../components/SidebarNav'
import { NavBreadcrumb } from '../components/NavBreadcrumb'
import './globals.css'

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en" className="h-full">
      <body className="h-full bg-gray-100 text-gray-900 antialiased overflow-hidden font-sans">
        <div className="flex h-screen overflow-hidden">
          {/* Laravel-style dark sidebar */}
          <aside className="hidden lg:flex w-64 flex-col bg-gray-800 z-20">
            <Link href="/" className="flex items-center gap-3 px-5 py-4 border-b border-gray-700">
              <div className="w-9 h-9 rounded bg-blue-600 flex items-center justify-center text-white flex-shrink-0">
                <School size={20} />
              </div>
              <span className="font-semibold text-white text-sm">EduManage</span>
            </Link>

            <SidebarNav />

            <div className="mt-auto p-4 border-t border-gray-700">
              <div className="flex items-center gap-3 px-3 py-2">
                <img
                  src="https://ui-avatars.com/api/?name=Admin+User&background=4b5563&color=fff&size=80"
                  alt=""
                  className="w-8 h-8 rounded-full flex-shrink-0"
                />
                <div className="flex-1 min-w-0">
                  <p className="text-sm font-medium text-gray-200 truncate">Admin User</p>
                  <p className="text-xs text-gray-500 truncate">Super Admin</p>
                </div>
                <button className="text-gray-500 hover:text-gray-300 p-1">
                  <LogOut size={16} />
                </button>
              </div>
            </div>
          </aside>

          {/* Main */}
          <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
            {/* Top navbar - Laravel style */}
            <header className="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 flex-shrink-0">
              <div className="flex items-center gap-4">
                <button className="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded">
                  <Menu size={20} />
                </button>
                <NavBreadcrumb />
              </div>

              <div className="flex items-center gap-2">
                <div className="hidden md:block relative">
                  <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
                  <input
                    type="text"
                    placeholder="Search..."
                    className="w-64 pl-9 pr-3 py-1.5 text-sm border border-gray-200 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <button className="p-2 text-gray-500 hover:bg-gray-100 rounded relative">
                  <Bell size={18} />
                  <span className="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full" />
                </button>
                <div className="flex items-center gap-2 pl-2 border-l border-gray-200">
                  <img
                    src="https://ui-avatars.com/api/?name=Admin&background=374151&color=fff&size=80"
                    alt=""
                    className="w-8 h-8 rounded-full"
                  />
                  <button className="flex items-center gap-1 text-sm text-gray-700 hover:text-gray-900">
                    Admin <ChevronDown size={14} />
                  </button>
                </div>
              </div>
            </header>

            <main className="flex-1 overflow-y-auto bg-gray-100 p-4 lg:p-6">
              {children}
            </main>
          </div>
        </div>
      </body>
    </html>
  )
}
